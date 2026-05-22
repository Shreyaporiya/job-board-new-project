import { Link, useLocation, useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";

export default function Header() {
    const [token, setToken] = useState(localStorage.getItem("token"));
    const [user, setUser] = useState(null);
    const location = useLocation();
    const navigate = useNavigate();
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

    useEffect(() => {
        const handleAuthChange = () => {
            const newToken = localStorage.getItem("token");
            setToken(newToken);
            if (newToken) {
                const userData = localStorage.getItem("user");
                if (userData) {
                    setUser(JSON.parse(userData));
                }
            } else {
                setUser(null);
            }
        };

        handleAuthChange();
        window.addEventListener("authChange", handleAuthChange);

        return () => {
            window.removeEventListener("authChange", handleAuthChange);
        };
    }, []);

    const logout = () => {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
        setToken(null);
        setUser(null);
        window.dispatchEvent(new Event("authChange"));
        navigate("/login");
    };

    const isActive = (path) => location.pathname === path;

    const styles = {
        header: {
            position: "sticky",
            top: 0,
            zIndex: 1000,
            background: "white",
            boxShadow: "0 4px 20px rgba(0, 0, 0, 0.05)",
            overflow: "hidden",
            width: "100%"
        },
        navContainer: {
            maxWidth: "1300px",
            margin: "0 auto",
            padding: "16px 24px",
            display: "flex",
            justifyContent: "space-between",
            alignItems: "center",
            width: "100%"
        },
        logoWrapper: {
            display: "flex",
            alignItems: "center",
            gap: "12px",
            textDecoration: "none",
            transition: "transform 0.3s ease"
        },
        logoIcon: {
            width: "42px",
            height: "42px",
            background: "linear-gradient(135deg, #667eea 0%, #764ba2 100%)",
            borderRadius: "12px",
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            fontSize: "22px",
            color: "white",
            boxShadow: "0 4px 10px rgba(102, 126, 234, 0.3)"
        },
        logoText: {
            fontSize: "24px",
            fontWeight: 800
        },
        logoMain: {
            color: "#1a202c"
        },
        logoAccent: {
            background: "linear-gradient(135deg, #667eea 0%, #764ba2 100%)",
            WebkitBackgroundClip: "text",
            WebkitTextFillColor: "transparent"
        },
        navLinks: {
            display: "flex",
            alignItems: "center",
            gap: "8px",
            flexWrap: "wrap"
        },
        navItem: {
            display: "flex",
            alignItems: "center",
            gap: "8px",
            padding: "10px 20px",
            color: "#4a5568",
            textDecoration: "none",
            fontWeight: 500,
            fontSize: "15px",
            borderRadius: "12px",
            transition: "all 0.3s ease"
        },
        navItemActive: {
            background: "linear-gradient(135deg, #667eea 0%, #764ba2 100%)",
            color: "white",
            boxShadow: "0 4px 12px rgba(102, 126, 234, 0.3)"
        },
        registerButton: {
            display: "flex",
            alignItems: "center",
            gap: "8px",
            padding: "10px 24px",
            background: "linear-gradient(135deg, #667eea 0%, #764ba2 100%)",
            color: "white",
            textDecoration: "none",
            fontWeight: 600,
            borderRadius: "12px",
            marginLeft: "8px",
            boxShadow: "0 4px 12px rgba(102, 126, 234, 0.3)",
            transition: "all 0.3s ease"
        },
        logoutButton: {
            display: "flex",
            alignItems: "center",
            gap: "8px",
            padding: "10px 20px",
            background: "none",
            border: "1px solid #e2e8f0",
            color: "#e53e3e",
            fontWeight: 500,
            fontSize: "15px",
            borderRadius: "12px",
            cursor: "pointer",
            transition: "all 0.3s ease"
        },
        welcomeText: {
            display: "flex",
            alignItems: "center",
            gap: "8px",
            padding: "10px 20px",
            color: "#667eea",
            fontWeight: 500,
            fontSize: "15px",
            backgroundColor: "rgba(102, 126, 234, 0.1)",
            borderRadius: "12px",
            marginLeft: "8px"
        },
        mobileMenuBtn: {
            display: "none",
            background: "none",
            border: "none",
            fontSize: "24px",
            color: "#667eea",
            cursor: "pointer",
            padding: "8px",
            borderRadius: "10px"
        }
    };

    return (
        <header style={styles.header}>
            <nav>
                <div style={styles.navContainer}>
                    <Link to="/" style={styles.logoWrapper}>
                        <div style={styles.logoIcon}>
                            <i className="fas fa-briefcase"></i>
                        </div>
                        <div style={styles.logoText}>
                            <span style={styles.logoMain}>Job</span>
                            <span style={styles.logoAccent}>Board</span>
                        </div>
                    </Link>

                    <button
                        style={styles.mobileMenuBtn}
                        className="mobile-menu-btn"
                        onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
                    >
                        <i className={`fas ${isMobileMenuOpen ? 'fa-times' : 'fa-bars'}`}></i>
                    </button>

                    <div style={styles.navLinks} className={`nav-links ${isMobileMenuOpen ? 'active' : ''}`}>
                        {token ? (
                            <>
                                <Link
                                    to="/"
                                    style={{
                                        ...styles.navItem,
                                        ...(isActive('/') ? styles.navItemActive : {})
                                    }}
                                    onClick={() => setIsMobileMenuOpen(false)}
                                >
                                    <i className="fas fa-home"></i>
                                    <span>Dashboard</span>
                                </Link>

                                <Link
                                    to="/add-job"
                                    style={{
                                        ...styles.navItem,
                                        ...(isActive('/add-job') ? styles.navItemActive : {})
                                    }}
                                    onClick={() => setIsMobileMenuOpen(false)}
                                >
                                    <i className="fas fa-plus-circle"></i>
                                    <span>Post Job</span>
                                </Link>

                                <Link
                                    to="/profile"
                                    style={{
                                        ...styles.navItem,
                                        ...(isActive('/profile') ? styles.navItemActive : {})
                                    }}
                                    onClick={() => setIsMobileMenuOpen(false)}
                                >
                                    <i className="fas fa-user-astronaut"></i>
                                    <span>Profile</span>
                                </Link>

                                {/* Welcome message with user name */}
                                {user && (
                                    <div style={styles.welcomeText}>
                                        <i className="fas fa-user-circle"></i>
                                        <span>Welcome, {user.name?.split(" ")[0] || "User"}!</span>
                                    </div>
                                )}

                                <button onClick={logout} style={styles.logoutButton}>
                                    <i className="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </>
                        ) : (
                            <>
                                <Link
                                    to="/login"
                                    style={{
                                        ...styles.navItem,
                                        ...(isActive('/login') ? styles.navItemActive : {})
                                    }}
                                    onClick={() => setIsMobileMenuOpen(false)}
                                >
                                    <i className="fas fa-sign-in-alt"></i>
                                    <span>Login</span>
                                </Link>

                                <Link
                                    to="/register"
                                    style={styles.registerButton}
                                    onClick={() => setIsMobileMenuOpen(false)}
                                >
                                    <i className="fas fa-user-plus"></i>
                                    <span>Get Started</span>
                                    <i className="fas fa-arrow-right"></i>
                                </Link>
                            </>
                        )}
                    </div>
                </div>
            </nav>

            <style>{`
                @media (max-width: 768px) {
                    .mobile-menu-btn {
                        display: flex !important;
                        align-items: center;
                        justify-content: center;
                    }
                    .nav-links {
                        position: fixed;
                        top: 80px;
                        left: -100%;
                        width: 100%;
                        height: calc(100vh - 80px);
                        background: white;
                        flex-direction: column;
                        align-items: stretch;
                        padding: 24px;
                        gap: 16px;
                        transition: left 0.3s ease;
                        box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
                        overflow-y: auto;
                        z-index: 999;
                    }
                    .nav-links.active {
                        left: 0;
                    }
                    .nav-links a, .nav-links button {
                        justify-content: center;
                    }
                }
            `}</style>
        </header>
    );
}