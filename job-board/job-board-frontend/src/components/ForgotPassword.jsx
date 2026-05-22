import { useState } from "react";
import { Link } from "react-router-dom";
import { gql, useMutation } from "@apollo/client";
import "../css/ForgotPassword.css";

const FORGOT_PASSWORD = gql`
  mutation ForgotPassword($email: String!) {
    forgotPassword(email: $email)
  }
`;

export default function ForgotPassword() {
    const [email, setEmail] = useState("");
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [touched, setTouched] = useState(false);

    const [forgotPassword, { loading }] = useMutation(FORGOT_PASSWORD);

    const validateEmail = (value) => {
        if (!value) return "Email is required";
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            return "Please enter a valid email address";
        }
        return "";
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        setTouched(true);
        setError("");
        setSuccess("");

        const validationError = validateEmail(email);

        if (validationError) {
            setError(validationError);
            return;
        }

        try {
            const { data } = await forgotPassword({
                variables: { email },
            });

            setSuccess(
                data.forgotPassword ||
                "Password reset link sent successfully."
            );

            setEmail("");
        } catch (err) {
            console.error(err);

            if (err.graphQLErrors?.length > 0) {
                setError(err.graphQLErrors[0].message);
            } else {
                setError("Something went wrong. Please try again.");
            }
        }
    };

    return (
        <div className="forgot-page">
            <div className="forgot-container">
                {/* Left Side */}
                <div className="forgot-illustration">
                    <div className="illustration-content">
                        <div className="illustration-icon">
                            <i className="fas fa-unlock-alt"></i>
                        </div>

                        <h2>Forgot Your Password?</h2>

                        <p>
                            No worries! Enter your email address and we'll send
                            you a password reset link.
                        </p>

                        <div className="illustration-features">
                            <div className="feature">
                                <i className="fas fa-shield-alt"></i>
                                <span>Secure password recovery</span>
                            </div>

                            <div className="feature">
                                <i className="fas fa-envelope"></i>
                                <span>Reset link via email</span>
                            </div>

                            <div className="feature">
                                <i className="fas fa-lock"></i>
                                <span>Keep your account protected</span>
                            </div>
                        </div>
                    </div>

                    <div className="illustration-bg"></div>
                </div>

                {/* Right Side */}
                <div className="forgot-form-wrapper">
                    <div className="forgot-form-container">

                        <div className="form-header">
                            <div className="form-badge">
                                <i className="fas fa-key"></i> Password Recovery
                            </div>

                            <h1>Reset Password</h1>

                            <p>
                                Enter your registered email address to receive a
                                reset link.
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
                            className="forgot-form"
                            noValidate
                        >
                            {/* Email */}
                            <div className="form-group">
                                <label htmlFor="email">
                                    <i className="fas fa-envelope me-2"></i>
                                    Email Address
                                </label>

                                <div
                                    className={`input-wrapper
                                    ${touched && error ? "error" : ""}
                                    ${touched && !error && email ? "success" : ""}
                                `}
                                >
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        placeholder="you@example.com"
                                        value={email}
                                        onChange={(e) =>
                                            setEmail(e.target.value)
                                        }
                                        onBlur={() => setTouched(true)}
                                        className="form-input"
                                    />

                                    {touched && !error && email && (
                                        <i className="fas fa-check-circle input-icon success-icon"></i>
                                    )}
                                </div>

                                {touched && error && (
                                    <div className="error-message">
                                        <i className="fas fa-exclamation-triangle"></i>
                                        {error}
                                    </div>
                                )}
                            </div>

                            {/* Button */}
                            <button
                                type="submit"
                                className="forgot-button"
                                disabled={loading}
                            >
                                {loading ? (
                                    <>
                                        <i className="fas fa-spinner fa-pulse"></i>
                                        Sending...
                                    </>
                                ) : (
                                    <>
                                        <i className="fas fa-paper-plane"></i>
                                        Send Reset Link
                                    </>
                                )}
                            </button>

                            {/* Back Login */}
                            <div className="back-login">
                                <p>
                                    Remember your password?
                                    <Link to="/login" className="login-link1 ps-0">
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