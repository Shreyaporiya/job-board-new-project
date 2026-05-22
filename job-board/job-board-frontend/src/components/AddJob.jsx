import { useState } from "react";
import { useMutation } from "@apollo/client";
import "../css/AddJob.css";
import { CREATE_JOB } from "../graphql/queries";

export default function AddJob() {
    const [formData, setFormData] = useState({
        title: "",
        company: "",
        description: "",
        location: "",
        salary: "",
        skills: "",
        responsibilities: "",
        jobType: "FULL_TIME"
    });

    const [errors, setErrors] = useState({});
    const [notification, setNotification] = useState({ show: false, type: "", message: "" });
    const [createJob, { loading }] = useMutation(CREATE_JOB);

    const showNotification = (type, message) => {
        setNotification({ show: true, type, message });
        setTimeout(() => {
            setNotification({ show: false, type: "", message: "" });
        }, 5000);
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
        if (errors[name]) {
            setErrors(prev => ({
                ...prev,
                [name]: ""
            }));
        }
    };

    const validateForm = () => {
        const newErrors = {};

        if (!formData.title.trim()) {
            newErrors.title = "Title is required";
        } else if (formData.title.length < 3) {
            newErrors.title = "Title must be at least 3 characters";
        }

        if (!formData.company.trim()) {
            newErrors.company = "Company is required";
        }

        if (!formData.description.trim()) {
            newErrors.description = "Description is required";
        } else if (formData.description.length < 20) {
            newErrors.description = "Description must be at least 20 characters";
        }

        if (!formData.location.trim()) {
            newErrors.location = "Location is required";
        }

        if (!formData.salary) {
            newErrors.salary = "Salary is required";
        } else if (parseFloat(formData.salary) <= 0) {
            newErrors.salary = "Salary must be greater than 0";
        }

        if (!formData.skills.trim()) {
            newErrors.skills = "Skills are required";
        }

        if (!formData.responsibilities.trim()) {
            newErrors.responsibilities = "Responsibilities are required";
        }

        return newErrors;
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        const newErrors = validateForm();

        if (Object.keys(newErrors).length > 0) {
            setErrors(newErrors);
            showNotification("error", "Please fix the validation errors before submitting");
            return;
        }

        try {
            await createJob({
                variables: {
                    title: formData.title,
                    company: formData.company,
                    description: formData.description,
                    location: formData.location,
                    salary: formData.salary,
                    skills: formData.skills.split(",").map(skill => skill.trim()),
                    responsibilities: formData.responsibilities.split(",").map(item => item.trim()),
                    job_type: formData.jobType,
                },
            });

            showNotification("success", `✅ "${formData.title}" has been posted successfully!`);

            setFormData({
                title: "",
                company: "",
                description: "",
                location: "",
                salary: "",
                skills: "",
                responsibilities: "",
                jobType: "FULL_TIME"
            });

        } catch (err) {
            console.error(err);
            showNotification("error", err.message || "Failed to add job. Please try again.");
        }
    };

    return (
        <div className="add-job-container">
            {/* Toast Notification */}
            {notification.show && (
                <div className={`toast-notification ${notification.type}`}>
                    <div className="toast-content">
                        {notification.type === "success" ? (
                            <svg className="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        ) : (
                            <svg className="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        )}
                        <span className="toast-message">{notification.message}</span>
                        <button
                            className="toast-close"
                            onClick={() => setNotification({ show: false, type: "", message: "" })}
                        >
                            ✕
                        </button>
                    </div>
                    <div className="toast-progress-bar"></div>
                </div>
            )}

            <div className="form-card">
                <div className="header">
                    <h2 className="title">➕ Add New Job</h2>
                    <p className="subtitle">Fill in the details to post a new job opening</p>
                </div>

                <form onSubmit={handleSubmit} className="form">
                    <div className="two-column-grid">
                        <div className="form-group">
                            <label className="label">
                                Job Title <span className="required">*</span>
                            </label>
                            <input
                                type="text"
                                name="title"
                                placeholder="e.g., Senior Frontend Developer"
                                value={formData.title}
                                onChange={handleChange}
                                className={errors.title ? "input input-error" : "input"}
                            />
                            {errors.title && <span className="error-text">{errors.title}</span>}
                        </div>

                        <div className="form-group">
                            <label className="label">
                                Company <span className="required">*</span>
                            </label>
                            <input
                                type="text"
                                name="company"
                                placeholder="e.g., Tech Corp Inc."
                                value={formData.company}
                                onChange={handleChange}
                                className={errors.company ? "input input-error" : "input"}
                            />
                            {errors.company && <span className="error-text">{errors.company}</span>}
                        </div>
                    </div>

                    <div className="two-column-grid">
                        <div className="form-group">
                            <label className="label">
                                Location <span className="required">*</span>
                            </label>
                            <input
                                type="text"
                                name="location"
                                placeholder="e.g., New York, NY (or Remote)"
                                value={formData.location}
                                onChange={handleChange}
                                className={errors.location ? "input input-error" : "input"}
                            />
                            {errors.location && <span className="error-text">{errors.location}</span>}
                        </div>

                        <div className="form-group">
                            <label className="label">
                                Salary (USD) <span className="required">*</span>
                            </label>
                            <input
                                type="number"
                                name="salary"
                                placeholder="e.g., 75000"
                                value={formData.salary}
                                onChange={handleChange}
                                className={errors.salary ? "input input-error" : "input"}
                            />
                            {errors.salary && <span className="error-text">{errors.salary}</span>}
                        </div>
                    </div>

                    <div className="form-group">
                        <label className="label">
                            Job Type <span className="required">*</span>
                        </label>
                        <select
                            name="jobType"
                            value={formData.jobType}
                            onChange={handleChange}
                            className="select"
                        >
                            <option value="Full Time">⏰ Full Time</option>
                            <option value="Part Time">🕒 Part Time</option>
                            <option value="Internship">🎓 Internship</option>
                            <option value="Remote">🏠 Remote</option>
                            <option value="Freelance">💼 Freelance</option>
                        </select>
                    </div>

                    <div className="form-group">
                        <label className="label">
                            Job Description <span className="required">*</span>
                        </label>
                        <textarea
                            name="description"
                            placeholder="Describe the role, responsibilities, requirements, and benefits..."
                            value={formData.description}
                            onChange={handleChange}
                            rows="5"
                            className={errors.description ? "textarea input-error" : "textarea"}
                        />
                        {errors.description && <span className="error-text">{errors.description}</span>}
                    </div>

                    <div className="form-group">
                        <label className="label">
                            Required Skills <span className="required">*</span>
                        </label>
                        <input
                            type="text"
                            name="skills"
                            placeholder="React, Node.js, TypeScript (comma separated)"
                            value={formData.skills}
                            onChange={handleChange}
                            className={errors.skills ? "input input-error" : "input"}
                        />
                        {errors.skills && <span className="error-text">{errors.skills}</span>}
                        <small className="helper-text">Separate skills with commas</small>
                    </div>

                    <div className="form-group">
                        <label className="label">
                            Key Responsibilities <span className="required">*</span>
                        </label>
                        <textarea
                            name="responsibilities"
                            placeholder="Develop new features, Write unit tests, Code reviews (comma separated)"
                            value={formData.responsibilities}
                            onChange={handleChange}
                            rows="3"
                            className={errors.responsibilities ? "textarea input-error" : "textarea"}
                        />
                        {errors.responsibilities && <span className="error-text">{errors.responsibilities}</span>}
                        <small className="helper-text">Separate responsibilities with commas</small>
                    </div>

                    <div className="button-group">
                        <button
                            type="submit"
                            disabled={loading}
                            className={loading ? "submit-button button-disabled" : "submit-button"}
                        >
                            {loading ? "⏳ Adding Job..." : "✅ Post Job"}
                        </button>

                        <button
                            type="button"
                            onClick={() => window.location.href = "/"}
                            className="cancel-button"
                        >
                            ✖️ Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}