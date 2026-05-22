import { useState, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";
import { useMutation } from "@apollo/client";
import "../css/Login.css";
import { LOGIN } from "../graphql/queries";

export default function Login() {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        email: "",
        password: "",
    });
    const [errors, setErrors] = useState({});
    const [touched, setTouched] = useState({});
    const [generalError, setGeneralError] = useState("");
    const [showPassword, setShowPassword] = useState(false);

    const [login, { loading }] = useMutation(LOGIN);

    // Check if already logged in
    useEffect(() => {
        const token = localStorage.getItem("token");
        if (token) {
            navigate("/");
        }
    }, [navigate]);

    const validateField = (name, value) => {
        switch (name) {
            case "email":
                if (!value) return "Email is required";
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return "Please enter a valid email address";
                return "";
            case "password":
                if (!value) return "Password is required";
                if (value.length < 6) return "Password must be at least 6 characters";
                return "";
            default:
                return "";
        }
    };

    const validateForm = () => {
        const newErrors = {};
        newErrors.email = validateField("email", formData.email);
        newErrors.password = validateField("password", formData.password);
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
        setTouched({ email: true, password: true });

        if (!validateForm()) {
            return;
        }

        try {
            const { data } = await login({
                variables: {
                    email: formData.email,
                    password: formData.password,
                },
            });

            localStorage.setItem("token", data.login.token);
            localStorage.setItem("user", JSON.stringify(data.login.user));

            // Dispatch custom event to notify Header of login
            window.dispatchEvent(new Event("authChange"));

            navigate("/");
        } catch (err) {
            console.error("Login error:", err);

            if (err.graphQLErrors && err.graphQLErrors.length > 0) {
                setGeneralError(err.graphQLErrors[0].message);
            } else if (err.message) {
                setGeneralError(err.message);
            } else {
                setGeneralError("Login failed. Please check your credentials.");
            }
        }
    };

    return (
        <div className="login-page">
            <div className="login-container">
                {/* Left Side - Illustration */}
                <div className="login-illustration">
                    <div className="illustration-content">
                        <div className="illustration-icon">
                            <i className="fas fa-briefcase"></i>
                        </div>
                        <h2>Welcome Back!</h2>
                        <p>Sign in to continue your job search journey and discover amazing opportunities.</p>
                        <div className="illustration-features">
                            <div className="feature">
                                <i className="fas fa-search"></i>
                                <span>Browse thousands of jobs</span>
                            </div>
                            <div className="feature">
                                <i className="fas fa-save"></i>
                                <span>Save your favorite positions</span>
                            </div>
                            <div className="feature">
                                <i className="fas fa-bell"></i>
                                <span>Get personalized job alerts</span>
                            </div>
                        </div>
                    </div>
                    <div className="illustration-bg"></div>
                </div>

                {/* Right Side - Login Form */}
                <div className="login-form-wrapper">
                    <div className="login-form-container">
                        <div className="form-header">
                            <div className="form-badge">
                                <i className="fas fa-lock"></i> Secure Login
                            </div>
                            <h1>Sign In</h1>
                            <p>Access your account to manage applications and track your progress.</p>
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

                        <form onSubmit={handleSubmit} className="login-form" noValidate>
                            {/* Email Field */}
                            <div className="form-group">
                                <label htmlFor="email">
                                    <i className="fas fa-envelope me-2"></i>
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
                                    <i className="fas fa-key me-2"></i>
                                    Password
                                </label>
                                <div className={`input-wrapper ${touched.password && errors.password ? "error" : ""} ${touched.password && !errors.password && formData.password ? "success" : ""}`}>
                                    <input
                                        type={showPassword ? "text" : "password"}
                                        id="password"
                                        name="password"
                                        placeholder="Enter your password"
                                        value={formData.password}
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        className="form-input"
                                        autoComplete="current-password"
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
                            </div>

                            {/* Forgot Password & Remember Me */}
                            <div className="form-options">
                                <label className="checkbox-label">
                                    {/* <input type="checkbox" />
                                    <span className="checkmark"></span>
                                    <span className="checkbox-text">Remember me</span> */}
                                </label>
                                <Link to="/forgot-password" className="forgot-link">
                                    Forgot Password?
                                </Link>
                            </div>

                            {/* Submit Button */}
                            <button
                                type="submit"
                                className="login-button"
                                disabled={loading}
                            >
                                {loading ? (
                                    <>
                                        <i className="fas fa-spinner fa-pulse"></i>
                                        Signing In...
                                    </>
                                ) : (
                                    <>
                                        <i className="fas fa-sign-in-alt"></i>
                                        Sign In
                                        <i className="fas fa-arrow-right"></i>
                                    </>
                                )}
                            </button>

                            {/* Register Link */}
                            <div className="register-prompt">
                                <p>
                                    Don't have an account?{" "}
                                    <Link to="/register" className="register-link">
                                        Create Account
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