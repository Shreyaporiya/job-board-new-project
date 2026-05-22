import { useState, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";
import { useMutation } from "@apollo/client";
import "../css/Register.css";
import { REGISTER } from "../graphql/queries";

export default function Register() {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        name: "",
        email: "",
        password: "",
        confirmPassword: "",
    });
    const [errors, setErrors] = useState({});
    const [touched, setTouched] = useState({});
    const [generalError, setGeneralError] = useState("");
    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    const [register, { loading }] = useMutation(REGISTER);

    // Check if already logged in
    useEffect(() => {
        const token = localStorage.getItem("token");
        if (token) {
            navigate("/");
        }
    }, [navigate]);

    const validateField = (name, value) => {
        switch (name) {
            case "name":
                if (!value) return "Full name is required";
                if (value.length < 2) return "Name must be at least 2 characters";
                if (value.length > 50) return "Name must be less than 50 characters";
                if (!/^[a-zA-Z\s\-']+$/.test(value)) return "Name can only contain letters, spaces, hyphens, and apostrophes";
                return "";

            case "email":
                if (!value) return "Email is required";
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return "Please enter a valid email address";
                return "";

            case "password":
                if (!value) return "Password is required";
                if (value.length < 8) return "Password must be at least 8 characters";
                if (!/(?=.*[a-z])/.test(value)) return "Password must contain at least one lowercase letter";
                if (!/(?=.*[A-Z])/.test(value)) return "Password must contain at least one uppercase letter";
                if (!/(?=.*\d)/.test(value)) return "Password must contain at least one number";
                if (!/(?=.*[@$!%*?&])/.test(value)) return "Password must contain at least one special character (@$!%*?&)";
                return "";

            case "confirmPassword":
                if (!value) return "Please confirm your password";
                if (value !== formData.password) return "Passwords do not match";
                return "";

            default:
                return "";
        }
    };

    const validateForm = () => {
        const newErrors = {};
        newErrors.name = validateField("name", formData.name);
        newErrors.email = validateField("email", formData.email);
        newErrors.password = validateField("password", formData.password);
        newErrors.confirmPassword = validateField("confirmPassword", formData.confirmPassword);
        setErrors(newErrors);
        return !Object.values(newErrors).some((error) => error);
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({ ...prev, [name]: value }));

        if (touched[name]) {
            const error = validateField(name, value);
            setErrors((prev) => ({ ...prev, [name]: error }));
        }
    };

    const handleBlur = (e) => {
        const { name, value } = e.target;
        setTouched((prev) => ({ ...prev, [name]: true }));
        const error = validateField(name, value);
        setErrors((prev) => ({ ...prev, [name]: error }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setGeneralError("");

        // Mark all fields as touched
        setTouched({
            name: true,
            email: true,
            password: true,
            confirmPassword: true,
        });

        if (!validateForm()) {
            return;
        }

        try {
            const { data } = await register({
                variables: {
                    name: formData.name,
                    email: formData.email,
                    password: formData.password,
                },
            });

            localStorage.setItem("token", data.register.token);
            localStorage.setItem("user", JSON.stringify(data.register.user));

            window.dispatchEvent(new Event("authChange"));
            navigate("/");
        } catch (err) {
            console.error("Registration error:", err);

            if (err.graphQLErrors && err.graphQLErrors.length > 0) {
                if (err.graphQLErrors[0].message.includes("email")) {
                    setErrors((prev) => ({ ...prev, email: "Email already exists" }));
                } else {
                    setGeneralError(err.graphQLErrors[0].message);
                }
            } else if (err.message) {
                setGeneralError(err.message);
            } else {
                setGeneralError("Registration failed. Please try again.");
            }
        }
    };

    return (
        <div className="register-page">
            <div className="register-container">
                {/* Left Side - Welcome Section */}
                <div className="register-welcome">
                    <div className="welcome-content">
                        <div className="welcome-icon">
                            <i className="fas fa-rocket"></i>
                        </div>
                        <h2>Join JobBoard Today!</h2>
                        <p>Create your account and start your journey to finding the perfect job opportunity.</p>

                        <div className="welcome-features">
                            <div className="feature-item">
                                <div className="feature-icon">
                                    <i className="fas fa-check-circle"></i>
                                </div>
                                <div className="feature-text">
                                    <h4>Free Access</h4>
                                    <p>Browse and apply to thousands of jobs</p>
                                </div>
                            </div>

                            <div className="feature-item">
                                <div className="feature-icon">
                                    <i className="fas fa-bell"></i>
                                </div>
                                <div className="feature-text">
                                    <h4>Job Alerts</h4>
                                    <p>Get notified about matching positions</p>
                                </div>
                            </div>

                            <div className="feature-item">
                                <div className="feature-icon">
                                    <i className="fas fa-chart-line"></i>
                                </div>
                                <div className="feature-text">
                                    <h4>Track Applications</h4>
                                    <p>Monitor your job application status</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {/* Right Side - Registration Form */}
                <div className="register-form-wrapper">
                    <div className="form-container">
                        <div className="form-header">
                            <div className="form-badge">
                                <i className="fas fa-user-plus"></i> Create Account
                            </div>
                            <h1>Get Started</h1>
                            <p>Fill in your details to create your account</p>
                        </div>

                        {generalError && (
                            <div className="alert-error">
                                <i className="fas fa-exclamation-circle"></i>
                                <span>{generalError}</span>
                                <button className="alert-close" onClick={() => setGeneralError("")}>
                                    <i className="fas fa-times"></i>
                                </button>
                            </div>
                        )}

                        <form onSubmit={handleSubmit} className="register-form" noValidate>
                            {/* Name Field */}
                            <div className="form-group">
                                <label htmlFor="name">
                                    <i className="fas fa-user me-2 ms-1"></i>
                                    Full Name
                                </label>
                                <div className={`input-wrapper ${touched.name && errors.name ? "error" : ""} ${touched.name && !errors.name && formData.name ? "success" : ""}`}>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        placeholder="John Doe"
                                        value={formData.name}
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        className="form-input"
                                        autoComplete="name"
                                    />
                                    {touched.name && !errors.name && formData.name && (
                                        <i className="fas fa-check-circle input-icon success-icon"></i>
                                    )}
                                </div>
                                {touched.name && errors.name && (
                                    <div className="error-message">
                                        <i className="fas fa-exclamation-triangle"></i>
                                        {errors.name}
                                    </div>
                                )}
                            </div>

                            {/* Email Field */}
                            <div className="form-group">
                                <label htmlFor="email">
                                    <i className="fas fa-envelope me-2 ms-1"></i>
                                    Email Address
                                </label>
                                <div className={`input-wrapper ${touched.email && errors.email ? "error" : ""} ${touched.email && !errors.email && formData.email ? "success" : ""}`}>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        placeholder="you@example.com"
                                        value={formData.email}
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        className="form-input"
                                        autoComplete="email"
                                    />
                                    {touched.email && !errors.email && formData.email && (
                                        <i className="fas fa-check-circle input-icon success-icon"></i>
                                    )}
                                </div>
                                {touched.email && errors.email && (
                                    <div className="error-message">
                                        <i className="fas fa-exclamation-triangle"></i>
                                        {errors.email}
                                    </div>
                                )}
                            </div>

                            {/* Password Field */}
                            <div className="form-group">
                                <label htmlFor="password">
                                    <i className="fas fa-lock me-2 ms-1"></i>
                                    Password
                                </label>
                                <div className={`input-wrapper ${touched.password && errors.password ? "error" : ""} ${touched.password && !errors.password && formData.password ? "success" : ""}`}>
                                    <input
                                        type={showPassword ? "text" : "password"}
                                        id="password"
                                        name="password"
                                        placeholder="Create a strong password"
                                        value={formData.password}
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        className="form-input"
                                        autoComplete="new-password"
                                    />
                                    <button
                                        type="button"
                                        className="password-toggle"
                                        onClick={() => setShowPassword(!showPassword)}
                                    >
                                        <i className={`fas ${showPassword ? "fa-eye-slash" : "fa-eye"}`}></i>
                                    </button>
                                </div>
                                {touched.password && errors.password && (
                                    <div className="error-message">
                                        <i className="fas fa-exclamation-triangle"></i>
                                        {errors.password}
                                    </div>
                                )}
                                {touched.password && !errors.password && formData.password && (
                                    <div className="password-strength">
                                        <div className={`strength-bar strength-${getPasswordStrength(formData.password)}`}></div>
                                        <span className="strength-text">
                                            {getPasswordStrengthText(formData.password)}
                                        </span>
                                    </div>
                                )}
                            </div>

                            {/* Confirm Password Field */}
                            <div className="form-group">
                                <label htmlFor="confirmPassword">
                                    <i className="fas fa-check-circle me-2 ms-1"></i>
                                    Confirm Password
                                </label>
                                <div className={`input-wrapper ${touched.confirmPassword && errors.confirmPassword ? "error" : ""} ${touched.confirmPassword && !errors.confirmPassword && formData.confirmPassword ? "success" : ""}`}>
                                    <input
                                        type={showConfirmPassword ? "text" : "password"}
                                        id="confirmPassword"
                                        name="confirmPassword"
                                        placeholder="Confirm your password"
                                        value={formData.confirmPassword}
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        className="form-input"
                                        autoComplete="new-password"
                                    />
                                    <button
                                        type="button"
                                        className="password-toggle"
                                        onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                                    >
                                        <i className={`fas ${showConfirmPassword ? "fa-eye-slash" : "fa-eye"}`}></i>
                                    </button>
                                </div>
                                {touched.confirmPassword && errors.confirmPassword && (
                                    <div className="error-message">
                                        <i className="fas fa-exclamation-triangle"></i>
                                        {errors.confirmPassword}
                                    </div>
                                )}
                            </div>

                            {/* Terms and Conditions */}
                            {/* <div className="terms-group">
                                <label className="checkbox-label">
                                    <input
                                        type="checkbox"
                                        checked={agreeTerms}
                                        onChange={(e) => setAgreeTerms(e.target.checked)}
                                    />
                                    <span className="checkmark"></span>
                                    <span className="checkbox-text">
                                        I agree to the <Link to="/terms">Terms of Service</Link> and{" "}
                                        <Link to="/privacy">Privacy Policy</Link>
                                    </span>
                                </label>
                            </div> */}

                            {/* Submit Button */}
                            <button
                                type="submit"
                                className="register-button"
                                disabled={loading}
                            >
                                {loading ? (
                                    <>
                                        <i className="fas fa-spinner fa-pulse"></i>
                                        Creating Account...
                                    </>
                                ) : (
                                    <>
                                        <i className="fas fa-user-plus"></i>
                                        Create Account
                                        <i className="fas fa-arrow-right"></i>
                                    </>
                                )}
                            </button>

                            <div className="register-prompt mt-4">
                                <p>
                                    Already have an account?{" "}
                                    <Link to="/login" className="register-link">
                                        Sign In
                                        <i className="fas fa-arrow-right"></i>
                                    </Link>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

// Helper functions for password strength
function getPasswordStrength(password) {
    if (!password) return 0;
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[@$!%*?&]/.test(password)) strength++;
    return Math.min(strength, 5);
}

function getPasswordStrengthText(password) {
    const strength = getPasswordStrength(password);
    if (strength === 0) return "";
    if (strength <= 2) return "Weak password";
    if (strength <= 3) return "Fair password";
    if (strength <= 4) return "Good password";
    return "Strong password";
}