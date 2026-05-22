import { useState } from "react";
import { useSearchParams, useNavigate, Link } from "react-router-dom";
import { useMutation } from "@apollo/client";
import "../css/ResetPassword.css";
import { RESET_PASSWORD } from "../graphql/queries";

export default function ResetPassword() {
    const [searchParams] = useSearchParams();
    const navigate = useNavigate();

    const token = searchParams.get("token");
    const email = searchParams.get("email");

    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [touched, setTouched] = useState({
        password: false,
        confirmPassword: false,
    });

    const [resetPassword, { loading }] = useMutation(RESET_PASSWORD);

    const validatePassword = (value) => {
        if (!value) return "Password is required";
        if (value.length < 8) return "Password must be at least 8 characters";
        if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value)) {
            return "Password must contain uppercase, lowercase, and number";
        }
        return "";
    };

    const validateConfirmPassword = (value) => {
        if (!value) return "Please confirm your password";
        if (value !== password) return "Passwords do not match";
        return "";
    };

    const passwordError = touched.password ? validatePassword(password) : "";
    const confirmPasswordError = touched.confirmPassword ? validateConfirmPassword(confirmPassword) : "";

    const handleSubmit = async (e) => {
        e.preventDefault();

        setTouched({
            password: true,
            confirmPassword: true,
        });
        setError("");
        setSuccess("");

        const passwordValidationError = validatePassword(password);
        const confirmValidationError = validateConfirmPassword(confirmPassword);

        if (passwordValidationError || confirmValidationError) {
            setError(passwordValidationError || confirmValidationError);
            return;
        }

        try {
            const { data } = await resetPassword({
                variables: {
                    email,
                    token,
                    password,
                },
            });

            setSuccess(data.resetPassword || "Password reset successfully! Redirecting to login...");

            setTimeout(() => {
                navigate("/login");
            }, 2000);

        } catch (err) {
            console.error(err);

            if (err.graphQLErrors?.length > 0) {
                setError(err.graphQLErrors[0].message);
            } else {
                setError("Something went wrong. Please try again or request a new reset link.");
            }
        }
    };

    // Check if token and email are present
    if (!token || !email) {
        return (
            <div className="reset-page">
                <div className="reset-container">
                    <div className="reset-form-wrapper">
                        <div className="reset-form-container">
                            <div className="form-header">
                                <div className="form-badge">
                                    <i className="fas fa-exclamation-triangle"></i> Invalid Link
                                </div>
                                <h1>Invalid Reset Link</h1>
                                <p>This password reset link is invalid or expired.</p>
                            </div>
                            <div className="back-login">
                                <Link to="/forgot-password" className="login-link">
                                    <i className="fas fa-chevron-left"></i>
                                    Request New Reset Link
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="reset-page">
            <div className="reset-container">
                {/* Left Side - Illustration */}
                <div className="reset-illustration">
                    <div className="illustration-content">
                        <div className="illustration-icon">
                            <i className="fas fa-lock"></i>
                        </div>

                        <h2>Create New Password</h2>

                        <p>
                            Your new password must be different from previously used passwords
                            and meet the security requirements.
                        </p>

                        <div className="illustration-features">
                            <div className="feature">
                                <i className="fas fa-check-circle"></i>
                                <span>Minimum 8 characters</span>
                            </div>

                            <div className="feature">
                                <i className="fas fa-check-circle"></i>
                                <span>Uppercase & lowercase letters</span>
                            </div>

                            <div className="feature">
                                <i className="fas fa-check-circle"></i>
                                <span>At least one number</span>
                            </div>
                        </div>
                    </div>

                    <div className="illustration-bg"></div>
                </div>

                {/* Right Side - Form */}
                <div className="reset-form-wrapper">
                    <div className="reset-form-container">

                        <div className="form-header">
                            <div className="form-badge">
                                <i className="fas fa-key"></i> Password Reset
                            </div>

                            <h1>Reset Password</h1>

                            <p>
                                Create a new secure password for your account.
                            </p>
                        </div>

                        {/* Success Message */}
                        {success && (
                            <div className="alert-success">
                                <i className="fas fa-check-circle"></i>
                                <span>{success}</span>
                            </div>
                        )}

                        {/* Error Message */}
                        {error && (
                            <div className="alert-error">
                                <i className="fas fa-exclamation-circle"></i>
                                <span>{error}</span>

                                <button
                                    className="alert-close"
                                    onClick={() => setError("")}
                                >
                                    <i className="fas fa-times"></i>
                                </button>
                            </div>
                        )}

                        <form
                            onSubmit={handleSubmit}
                            className="reset-form"
                            noValidate
                        >
                            {/* New Password */}
                            <div className="form-group">
                                <label htmlFor="password">
                                    <i className="fas fa-lock me-2"></i>
                                    New Password
                                </label>

                                <div
                                    className={`input-wrapper
                                        ${touched.password && passwordError ? "error" : ""}
                                        ${touched.password && !passwordError && password ? "success" : ""}
                                    `}
                                >
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Enter your new password"
                                        value={password}
                                        onChange={(e) => {
                                            setPassword(e.target.value);
                                            if (confirmPassword) {
                                                setTouched(prev => ({ ...prev, confirmPassword: true }));
                                            }
                                        }}
                                        onBlur={() => setTouched(prev => ({ ...prev, password: true }))}
                                        className="form-input"
                                    />

                                    {touched.password && !passwordError && password && (
                                        <i className="fas fa-check-circle input-icon success-icon"></i>
                                    )}
                                </div>

                                {touched.password && passwordError && (
                                    <div className="error-message">
                                        <i className="fas fa-exclamation-triangle"></i>
                                        {passwordError}
                                    </div>
                                )}
                            </div>

                            {/* Confirm Password */}
                            <div className="form-group">
                                <label htmlFor="confirmPassword">
                                    <i className="fas fa-check-circle me-2"></i>
                                    Confirm Password
                                </label>

                                <div
                                    className={`input-wrapper
                                        ${touched.confirmPassword && confirmPasswordError ? "error" : ""}
                                        ${touched.confirmPassword && !confirmPasswordError && confirmPassword ? "success" : ""}
                                    `}
                                >
                                    <input
                                        type="password"
                                        id="confirmPassword"
                                        name="confirmPassword"
                                        placeholder="Confirm your new password"
                                        value={confirmPassword}
                                        onChange={(e) => setConfirmPassword(e.target.value)}
                                        onBlur={() => setTouched(prev => ({ ...prev, confirmPassword: true }))}
                                        className="form-input"
                                    />

                                    {touched.confirmPassword && !confirmPasswordError && confirmPassword && (
                                        <i className="fas fa-check-circle input-icon success-icon"></i>
                                    )}
                                </div>

                                {touched.confirmPassword && confirmPasswordError && (
                                    <div className="error-message">
                                        <i className="fas fa-exclamation-triangle"></i>
                                        {confirmPasswordError}
                                    </div>
                                )}
                            </div>

                            {/* Password Strength Indicator */}
                            {password && !passwordError && (
                                <div className="password-strength">
                                    <div className="strength-bar">
                                        <div
                                            className={`strength-level ${password.length >= 8 &&
                                                /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(password)
                                                ? "strong"
                                                : password.length >= 8
                                                    ? "medium"
                                                    : "weak"
                                                }`}
                                            style={{
                                                width: password.length >= 8 &&
                                                    /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(password)
                                                    ? "100%"
                                                    : password.length >= 8
                                                        ? "66%"
                                                        : "33%"
                                            }}
                                        ></div>
                                    </div>
                                    <p className="strength-text">
                                        {password.length >= 8 &&
                                            /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(password)
                                            ? "✓ Strong password"
                                            : password.length >= 8
                                                ? "Medium strength - add uppercase & numbers"
                                                : "Weak password - minimum 8 characters"}
                                    </p>
                                </div>
                            )}

                            {/* Button */}
                            <button
                                type="submit"
                                className="reset-button"
                                disabled={loading}
                            >
                                {loading ? (
                                    <>
                                        <i className="fas fa-spinner fa-pulse"></i>
                                        Updating...
                                    </>
                                ) : (
                                    <>
                                        <i className="fas fa-save"></i>
                                        Reset Password
                                    </>
                                )}
                            </button>

                            {/* Back Login */}
                            <div className="back-login">
                                <p>
                                    Remember your password?{" "}
                                    <Link to="/login" className="login-link2">
                                        Back to Login
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