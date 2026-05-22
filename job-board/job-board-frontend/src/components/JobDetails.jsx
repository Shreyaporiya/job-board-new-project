import { useParams, useNavigate } from "react-router-dom";
import { useQuery } from "@apollo/client";
import { useState } from "react";
import "../css/JobDetails.css";
import { GET_JOB } from "../graphql/queries";

export default function JobDetails() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [notification, setNotification] = useState({ show: false, type: "", message: "" });

    const { data, loading, error } = useQuery(GET_JOB, {
        variables: { id },
    });

    const showNotification = (type, message) => {
        setNotification({ show: true, type, message });
        setTimeout(() => {
            setNotification({ show: false, type: "", message: "" });
        }, 5000);
    };

    if (loading) {
        return (
            <div className="loading-container">
                <div className="loading-spinner"></div>
                <p>Loading job details...</p>
            </div>
        );
    }

    if (error) {
        return (
            <div className="error-container">
                <div className="error-icon">⚠️</div>
                <h2>Error Loading Job</h2>
                <p>{error.message}</p>
                <button onClick={() => navigate(-1)} className="error-back-btn">
                    Go Back
                </button>
            </div>
        );
    }

    const job = data.job;

    return (
        <div className="job-details-page">
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

            <div className="job-details-card">
                <button className="back-btn" onClick={() => navigate(-1)}>
                    ← Back to Jobs
                </button>

                <div className="top-section">
                    <div className="company-logo">
                        {job.company.charAt(0)}
                    </div>
                    <div className="title-section">
                        <h1>{job.title}</h1>
                        <h3>{job.company}</h3>
                    </div>
                    <div className="job-badge">
                        {job.job_type}
                    </div>
                </div>

                <div className="job-info-grid">
                    <div className="info-card">
                        <div className="info-icon">📍</div>
                        <div>
                            <strong>Location</strong>
                            <p>{job.location}</p>
                        </div>
                    </div>

                    <div className="info-card">
                        <div className="info-icon">💰</div>
                        <div>
                            <strong>Salary</strong>
                            <p>₹{job.salary.toLocaleString()} / year</p>
                        </div>
                    </div>

                    <div className="info-card">
                        <div className="info-icon">💼</div>
                        <div>
                            <strong>Job Type</strong>
                            <p>{job.job_type.replace('_', ' ')}</p>
                        </div>
                    </div>

                    <div className="info-card">
                        <div className="info-icon">👤</div>
                        <div>
                            <strong>Posted By</strong>
                            <p>{job.user.name}</p>
                        </div>
                    </div>
                </div>

                <div className="details-section">
                    <h2>
                        <span className="section-icon">📋</span>
                        Job Description
                    </h2>
                    <div className="description-content">
                        <p>{job.description}</p>
                    </div>
                </div>

                <div className="details-section">
                    <h2>
                        <span className="section-icon">⚡</span>
                        Required Skills
                    </h2>
                    <div className="skills-container">
                        {job.skills.map((skill, index) => (
                            <span key={index} className="skill-tag">
                                {skill}
                            </span>
                        ))}
                    </div>
                </div>

                <div className="details-section">
                    <h2>
                        <span className="section-icon">📝</span>
                        Key Responsibilities
                    </h2>
                    <ul className="responsibilities-list">
                        {job.responsibilities.map((responsibility, index) => (
                            <li key={index}>
                                <span className="checkmark">✓</span>
                                {responsibility}
                            </li>
                        ))}
                    </ul>
                </div>

                <div className="action-buttons">
                    <button className="save-btn" onClick={() => showNotification("success", "Job saved to your favorites!")}>
                        Save Job
                    </button>
                </div>
            </div>
        </div>
    );
}