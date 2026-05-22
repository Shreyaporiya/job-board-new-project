import { useState } from "react";
import { useQuery, useMutation } from "@apollo/client";
import { useNavigate } from "react-router-dom";
import "../css/Profile.css";
import {
    GET_ME,
    UPDATE_PROFILE,
    DELETE_PROFILE,
    UPDATE_JOB,
    DELETE_JOB
} from "../graphql/queries";

export default function Profile() {
    const navigate = useNavigate();

    const { data, loading, refetch } = useQuery(GET_ME);

    const [updateProfile] = useMutation(UPDATE_PROFILE);
    const [deleteProfile] = useMutation(DELETE_PROFILE);
    const [updateJob] = useMutation(UPDATE_JOB);
    const [deleteJob] = useMutation(DELETE_JOB);

    const [isEditingProfile, setIsEditingProfile] = useState(false);
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [selectedJob, setSelectedJob] = useState(null);
    const [editingJob, setEditingJob] = useState(null);
    const [showViewModal, setShowViewModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);
    const [showAccountDeleteConfirm, setShowAccountDeleteConfirm] = useState(false);
    const [jobToDelete, setJobToDelete] = useState(null);

    const [notification, setNotification] = useState({
        show: false,
        type: "",
        message: "",
    });

    const [jobForm, setJobForm] = useState({
        title: "",
        company: "",
        description: "",
        location: "",
        salary: "",
        skills: "",
        responsibilities: "",
        job_type: "FULL_TIME",
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
                <p>Loading profile...</p>
            </div>
        );
    }

    if (!data || !data.me) {
        return (
            <div className="loading-container">
                <p>No user data found. Please login again.</p>
                <button onClick={() => navigate("/login")}>
                    Go to Login
                </button>
            </div>
        );
    }

    const user = data.me;

    const handleUpdateProfile = async (e) => {
        e.preventDefault();
        try {
            await updateProfile({
                variables: {
                    name,
                    email,
                    password: password || null,
                },
            });
            showNotification("success", "Profile updated successfully!");
            setIsEditingProfile(false);
            refetch();
            setName("");
            setEmail("");
            setPassword("");
        } catch (err) {
            showNotification("error", err.message);
        }
    };

    const handleDeleteProfile = async () => {
        try {
            await deleteProfile();

            localStorage.removeItem("token");
            localStorage.removeItem("user");

            showNotification(
                "success",
                "Profile deleted successfully"
            );

            setShowAccountDeleteConfirm(false);

            setTimeout(() => navigate("/login"), 1500);
        } catch (err) {
            showNotification("error", err.message);
        }
    };

    const handleViewJob = (job) => {
        setSelectedJob(job);
        setShowViewModal(true);
    };

    const handleEditJob = (job) => {
        setEditingJob(job);
        setJobForm({
            title: job.title,
            company: job.company,
            description: job.description,
            location: job.location,
            salary: job.salary,
            skills: job.skills?.join(", ") || "",
            responsibilities: job.responsibilities?.join(", ") || "",
            job_type: job.job_type,
        });
        setShowEditModal(true);
    };

    const handleUpdateJob = async (e) => {
        e.preventDefault();
        try {
            await updateJob({
                variables: {
                    id: editingJob.id,
                    title: jobForm.title,
                    company: jobForm.company,
                    description: jobForm.description,
                    location: jobForm.location,
                    salary: jobForm.salary,
                    skills: jobForm.skills.split(",").map((s) => s.trim()),
                    responsibilities: jobForm.responsibilities
                        .split(",")
                        .map((r) => r.trim()),
                    job_type: jobForm.job_type,
                },
            });
            showNotification("success", "Job updated successfully!");
            setShowEditModal(false);
            setEditingJob(null);
            refetch();
        } catch (err) {
            showNotification("error", err.message);
        }
    };

    const handleDeleteJob = async () => {
        try {
            await deleteJob({ variables: { id: jobToDelete.id } });
            showNotification("success", "Job deleted successfully!");
            setShowDeleteConfirm(false);
            setJobToDelete(null);
            refetch();
        } catch (err) {
            showNotification("error", err.message);
        }
    };

    return (
        <div className="profile-container">
            {/* Toast Notification */}
            {notification.show && (
                <div className={`toast-notification ${notification.type}`}>
                    <div className="toast-content">
                        <span className="toast-message">{notification.message}</span>
                        <button
                            className="toast-close"
                            onClick={() =>
                                setNotification({ show: false, type: "", message: "" })
                            }
                        >
                            ✕
                        </button>
                    </div>
                    <div className="toast-progress-bar"></div>
                </div>
            )}

            <div className="content-wrapper">
                {/* PROFILE SECTION - REDESIGNED */}
                <div className="profile-section-new">
                    <div className="profile-header-new">
                        <div className="profile-avatar-new">
                            <div className="avatar-initials">
                                {user.name?.charAt(0).toUpperCase() || "U"}
                                {user.name?.charAt(1)?.toUpperCase() || ""}
                            </div>
                        </div>
                        <div className="profile-info-new">
                            <h2>{user.name}</h2>
                            <p>{user.email}</p>
                        </div>
                    </div>

                    <div className="profile-stats-new">
                        <div className="stat-item">
                            <span className="stat-value">{user.jobs?.length || 0}</span>
                            <span className="stat-label">Jobs Posted</span>
                        </div>
                    </div>

                    <div className="profile-actions-new">
                        <button
                            className="edit-profile-btn"
                            onClick={() => {
                                setName(user.name);
                                setEmail(user.email);
                                setIsEditingProfile(true);
                            }}
                        >
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z" />
                            </svg>
                            Edit Profile
                        </button>
                        <button
                            className="delete-profile-btn"
                            onClick={() => setShowAccountDeleteConfirm(true)}
                        >
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>

                {/* EDIT PROFILE MODAL */}
                {isEditingProfile && (
                    <div className="modal-overlay" onClick={() => setIsEditingProfile(false)}>
                        <div className="edit-profile-modal" onClick={(e) => e.stopPropagation()}>
                            <div className="edit-modal-header">
                                <h3>Account Information</h3>
                                <button className="close-modal" onClick={() => setIsEditingProfile(false)}>✕</button>
                            </div>
                            <form onSubmit={handleUpdateProfile} className="edit-profile-form">
                                <div className="form-group">
                                    <label>Full Name</label>
                                    <input
                                        type="text"
                                        value={name}
                                        onChange={(e) => setName(e.target.value)}
                                        required
                                    />
                                </div>
                                <div className="form-group">
                                    <label>Email Address</label>
                                    <input
                                        type="email"
                                        value={email}
                                        onChange={(e) => setEmail(e.target.value)}
                                        required
                                    />
                                </div>

                                <div className="form-group">
                                    <label>Password</label>

                                    <input
                                        type="password"
                                        placeholder="Enter new password"
                                        value={password}
                                        onChange={(e) => setPassword(e.target.value)}
                                    />

                                    <small className="password-note">
                                        Leave blank if you don't want to change password
                                    </small>
                                </div>
                                <p className="form-note">
                                    Your account is secure. Update your information anytime.
                                </p>
                                <div className="modal-buttons">
                                    <button
                                        type="button"
                                        className="cancel-btn"
                                        onClick={() => setIsEditingProfile(false)}
                                    >
                                        Cancel
                                    </button>
                                    <button type="submit" className="save-btn">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}

                {/* JOBS SECTION */}
                <div className="jobs-section-modern">
                    <div className="jobs-header-modern">
                        <div className="header-title">
                            <i className="fas fa-briefcase"></i>
                            <h2>My Posted Jobs</h2>
                        </div>
                        <p className="jobs-subtitle">Manage and track your job listings</p>
                        <button onClick={() => navigate("/add-job")} className="post-job-btn-modern">
                            <i className="fas fa-plus"></i> Post New Job
                        </button>
                    </div>

                    {!user.jobs || user.jobs.length === 0 ? (
                        <div className="empty-state-modern">
                            <div className="empty-animation">📭</div>
                            <h3>No Jobs Posted Yet</h3>
                            <p>Start your journey by posting your first job opportunity!</p>
                        </div>
                    ) : (
                        <div className="jobs-grid-modern">
                            {user.jobs.map((job) => (
                                <div key={job.id} className="job-card-modern">
                                    <div className="card-gradient-bar"></div>
                                    <div className="card-content">
                                        <div className="card-header-modern">
                                            <div className="job-icon-modern">
                                                <i className="fas fa-briefcase"></i>
                                            </div>
                                            <div className="job-title-modern">
                                                <h3>{job.title}</h3>
                                                <span className="company-name-modern">
                                                    <i className="fas fa-building"></i> {job.company}
                                                </span>
                                            </div>
                                            <span className="job-type-badge-modern">{job.job_type}</span>
                                        </div>

                                        <div className="job-details-modern">
                                            <div className="detail-chip">
                                                <i className="fas fa-map-marker-alt"></i>
                                                <span>{job.location}</span>
                                            </div>
                                            <div className="detail-chip">
                                                <i className="fas fa-rupee-sign"></i>
                                                <span>₹{job.salary}</span>
                                            </div>
                                        </div>

                                        {/* SKILLS SECTION ON JOB CARD */}
                                        {job.skills && job.skills.length > 0 && (
                                            <div className="job-skills-preview">
                                                {job.skills.slice(0, 3).map((skill, idx) => (
                                                    <span key={idx} className="skill-pill">
                                                        {skill}
                                                    </span>
                                                ))}
                                                {job.skills.length > 3 && (
                                                    <span className="skill-pill more-skills">
                                                        +{job.skills.length - 3}
                                                    </span>
                                                )}
                                            </div>
                                        )}

                                        <div className="card-actions-modern">
                                            <button
                                                className="action-btn view-btn"
                                                onClick={() => handleViewJob(job)}
                                            >
                                                <i className="fas fa-eye"></i> View
                                            </button>
                                            <button
                                                className="action-btn edit-btn"
                                                onClick={() => handleEditJob(job)}
                                            >
                                                <i className="fas fa-edit"></i> Edit
                                            </button>
                                            <button
                                                className="action-btn delete-btn"
                                                onClick={() => {
                                                    setJobToDelete(job);
                                                    setShowDeleteConfirm(true);
                                                }}
                                            >
                                                <i className="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>

            {/* View Job Modal */}
            {showViewModal && selectedJob && (
                <div className="modal-overlay" onClick={() => setShowViewModal(false)}>
                    <div className="job-details-modal" onClick={(e) => e.stopPropagation()}>
                        <button className="modal-close-btn" onClick={() => setShowViewModal(false)}>
                            ✕
                        </button>
                        <div className="modal-header">
                            <div className="modal-job-icon">
                                <i className="fas fa-briefcase"></i>
                            </div>
                            <div className="modal-job-title">
                                <h2>{selectedJob.title}</h2>
                                <div className="modal-company">
                                    <i className="fas fa-building"></i> {selectedJob.company}
                                    <span className="modal-job-badge">{selectedJob.job_type}</span>
                                </div>
                            </div>
                        </div>
                        <div className="modal-body">
                            <div className="details-grid">
                                <div className="detail-card">
                                    <div className="detail-icon">
                                        <i className="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div className="detail-info">
                                        <label>Location</label>
                                        <p>{selectedJob.location}</p>
                                    </div>
                                </div>
                                <div className="detail-card">
                                    <div className="detail-icon">
                                        <i className="fas fa-rupee-sign"></i>
                                    </div>
                                    <div className="detail-info">
                                        <label>Salary</label>
                                        <p>₹{selectedJob.salary}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="modal-section">
                                <h3>
                                    <i className="fas fa-align-left"></i> Description
                                </h3>
                                <p className="description-content">{selectedJob.description}</p>
                            </div>
                            <div className="modal-section">
                                <h3>
                                    <i className="fas fa-code"></i> Required Skills
                                </h3>
                                <div className="skills-container">
                                    {selectedJob.skills?.map((skill, idx) => (
                                        <span key={idx} className="skill-badge">
                                            {skill}
                                        </span>
                                    ))}
                                </div>
                            </div>
                            <div className="modal-section">
                                <h3>
                                    <i className="fas fa-tasks"></i> Responsibilities
                                </h3>
                                <ul className="responsibilities-list">
                                    {selectedJob.responsibilities?.map((resp, idx) => (
                                        <li key={idx}>
                                            <i className="fas fa-check-circle"></i> {resp}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                        <div className="modal-footer">
                            <button
                                className="modal-edit-btn"
                                onClick={() => {
                                    setShowViewModal(false);
                                    handleEditJob(selectedJob);
                                }}
                            >
                                <i className="fas fa-edit"></i> Edit Job
                            </button>
                            <button
                                className="modal-delete-btn"
                                onClick={() => {
                                    setShowViewModal(false);
                                    setJobToDelete(selectedJob);
                                    setShowDeleteConfirm(true);
                                }}
                            >
                                <i className="fas fa-trash"></i> Delete Job
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Edit Job Modal */}
            {showEditModal && editingJob && (
                <div className="modal-overlay" onClick={() => setShowEditModal(false)}>
                    <div className="edit-job-modal" onClick={(e) => e.stopPropagation()}>
                        <div className="edit-modal-header">
                            <div className="edit-modal-icon">
                                <i className="fas fa-edit"></i>
                            </div>
                            <h2>Edit Job</h2>
                            <p>Update your job listing details</p>
                        </div>
                        <form onSubmit={handleUpdateJob} className="edit-job-form">
                            <div className="form-row">
                                <div className="form-field">
                                    <label>Job Title *</label>
                                    <input
                                        type="text"
                                        value={jobForm.title}
                                        onChange={(e) => setJobForm({ ...jobForm, title: e.target.value })}
                                        required
                                    />
                                </div>
                                <div className="form-field">
                                    <label>Company *</label>
                                    <input
                                        type="text"
                                        value={jobForm.company}
                                        onChange={(e) => setJobForm({ ...jobForm, company: e.target.value })}
                                        required
                                    />
                                </div>
                            </div>
                            <div className="form-row">
                                <div className="form-field">
                                    <label>Location *</label>
                                    <input
                                        type="text"
                                        value={jobForm.location}
                                        onChange={(e) => setJobForm({ ...jobForm, location: e.target.value })}
                                        required
                                    />
                                </div>
                                <div className="form-field">
                                    <label>Salary *</label>
                                    <input
                                        type="text"
                                        value={jobForm.salary}
                                        onChange={(e) => setJobForm({ ...jobForm, salary: e.target.value })}
                                        required
                                    />
                                </div>
                            </div>
                            <div className="form-row">
                                <div className="form-field">
                                    <label>Job Type *</label>
                                    <select
                                        value={jobForm.job_type}
                                        onChange={(e) => setJobForm({ ...jobForm, job_type: e.target.value })}
                                    >
                                        <option value="FULL_TIME">Full Time</option>
                                        <option value="PART_TIME">Part Time</option>
                                        <option value="CONTRACT">Contract</option>
                                        <option value="INTERNSHIP">Internship</option>
                                        <option value="REMOTE">Remote</option>
                                    </select>
                                </div>
                                <div className="form-field">
                                    <label>Skills (comma separated)</label>
                                    <input
                                        type="text"
                                        value={jobForm.skills}
                                        onChange={(e) => setJobForm({ ...jobForm, skills: e.target.value })}
                                        placeholder="React, Node.js, MongoDB"
                                    />
                                </div>
                            </div>
                            <div className="form-field">
                                <label>Responsibilities (comma separated)</label>
                                <textarea
                                    rows="3"
                                    value={jobForm.responsibilities}
                                    onChange={(e) => setJobForm({ ...jobForm, responsibilities: e.target.value })}
                                    placeholder="Develop features, Write tests, Deploy applications"
                                />
                            </div>
                            <div className="form-field">
                                <label>Description *</label>
                                <textarea
                                    rows="4"
                                    value={jobForm.description}
                                    onChange={(e) => setJobForm({ ...jobForm, description: e.target.value })}
                                    required
                                />
                            </div>
                            <div className="edit-modal-actions">
                                <button
                                    type="button"
                                    className="cancel-edit-modal"
                                    onClick={() => setShowEditModal(false)}
                                >
                                    Cancel
                                </button>
                                <button type="submit" className="save-edit-modal">
                                    <i className="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Delete Confirmation Modal */}
            {showDeleteConfirm && jobToDelete && (
                <div className="modal-overlay" onClick={() => setShowDeleteConfirm(false)}>
                    <div className="delete-modal" onClick={(e) => e.stopPropagation()}>
                        <div className="modal-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                        </div>
                        <h3>Delete Job</h3>
                        <p>
                            Are you sure you want to delete <strong>"{jobToDelete.title}"</strong>? <br />
                            This action cannot be undone.
                        </p>
                        <div className="modal-buttons">
                            <button className="modal-cancel" onClick={() => setShowDeleteConfirm(false)}>
                                Cancel
                            </button>
                            <button className="modal-confirm" onClick={handleDeleteJob}>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Account Delete Confirmation Modal */}
            {showAccountDeleteConfirm && (
                <div
                    className="modal-overlay"
                    onClick={() => setShowAccountDeleteConfirm(false)}
                >
                    <div
                        className="delete-modal"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <div className="modal-icon danger-icon">
                            <svg
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                        </div>

                        <h3>Delete Account</h3>

                        <p>
                            Are you sure you want to permanently delete
                            your account?
                            <br />
                            <strong>This action cannot be undone.</strong>
                        </p>

                        <div className="modal-buttons">
                            <button
                                className="modal-cancel"
                                onClick={() =>
                                    setShowAccountDeleteConfirm(false)
                                }
                            >
                                Cancel
                            </button>

                            <button
                                className="modal-confirm"
                                onClick={handleDeleteProfile}
                            >
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}