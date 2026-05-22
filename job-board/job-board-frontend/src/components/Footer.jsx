import { Link } from "react-router-dom";
import "../css/Footer.css";

export default function Footer() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className="modern-footer">

            <div className="footer-content">
                <div className="footer-container">
                    {/* Brand Section */}
                    <div className="footer-section brand-section">
                        <div className="footer-logo">
                            <div className="logo-icon">
                                <i className="fas fa-briefcase"></i>
                            </div>
                            <div className="logo-text">
                                <span>Job</span>
                                <span className="logo-accent">Board</span>
                            </div>
                        </div>
                        <p className="brand-description">
                            Connecting talented professionals with amazing career opportunities worldwide.
                        </p>
                        <div className="social-links">
                            <a href="#" className="social-link linkedin">
                                <i className="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" className="social-link twitter">
                                <i className="fab fa-twitter"></i>
                            </a>
                            <a href="#" className="social-link facebook">
                                <i className="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" className="social-link instagram">
                                <i className="fab fa-instagram"></i>
                            </a>
                            <a href="#" className="social-link github">
                                <i className="fab fa-github"></i>
                            </a>
                        </div>
                    </div>

                    {/* Quick Links */}
                    <div className="footer-section">
                        <h3 className="footer-title">
                            <i className="fas fa-rocket"></i>
                            Quick Links
                        </h3>
                        <ul className="footer-links">
                            <li><Link to="/"><i className="fas fa-chevron-right"></i> Browse Jobs</Link></li>
                            <li><Link to="/add-job"><i className="fas fa-chevron-right"></i> Post a Job</Link></li>
                            <li><Link to="/companies"><i className="fas fa-chevron-right"></i> Favorite jobs</Link></li>
                            <li><Link to="/salary-guide"><i className="fas fa-chevron-right"></i> Salary Guide</Link></li>
                        </ul>
                    </div>

                    {/* Resources */}
                    <div className="footer-section">
                        <h3 className="footer-title">
                            <i className="fas fa-graduation-cap"></i>
                            Resources
                        </h3>
                        <ul className="footer-links">
                            <li><Link to="/career-tips"><i className="fas fa-chevron-right"></i> Career Tips</Link></li>
                            <li><Link to="/resume-guide"><i className="fas fa-chevron-right"></i> Resume Guide</Link></li>
                            <li><Link to="/interview-prep"><i className="fas fa-chevron-right"></i> Interview Prep</Link></li>
                            <li><Link to="/blog"><i className="fas fa-chevron-right"></i> Blog</Link></li>
                        </ul>
                    </div>

                    {/* Support */}
                    <div className="footer-section">
                        <h3 className="footer-title">
                            <i className="fas fa-headset"></i>
                            Support
                        </h3>
                        <ul className="footer-links">
                            <li><Link to="/help"><i className="fas fa-chevron-right"></i> Help Center</Link></li>
                            <li><Link to="/contact"><i className="fas fa-chevron-right"></i> Contact Us</Link></li>
                            <li><Link to="/privacy"><i className="fas fa-chevron-right"></i> Privacy Policy</Link></li>
                            <li><Link to="/terms"><i className="fas fa-chevron-right"></i> Terms of Service</Link></li>
                        </ul>
                    </div>

                </div>

                {/* Footer Bottom */}
                <div className="footer-bottom">
                    <div className="bottom-container">
                        <div className="copyright">
                            <i className="far fa-copyright"></i>
                            <span>{currentYear} JobBoard. All rights reserved.</span>
                        </div>
                        <div className="bottom-links">
                            <Link to="/sitemap">Sitemap</Link>
                            <span className="separator">|</span>
                            <Link to="/accessibility">Accessibility</Link>
                            <span className="separator">|</span>
                            <Link to="/cookies">Cookie Policy</Link>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    );
}