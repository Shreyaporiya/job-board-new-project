import {
    useQuery,
    useMutation,
} from "@apollo/client";

import {
    GET_JOBS,
    GET_FAVORITES,
    ADD_FAVORITE,
    REMOVE_FAVORITE,
} from "../graphql/queries";

import { useState } from "react";

import { useNavigate } from "react-router-dom";

import "../css/JobList.css";

export default function JobList() {

    // GET JOBS
    const {
        data,
        loading,
        error,
    } = useQuery(GET_JOBS);

    // GET FAVORITES
    const {
        data: favoriteData,
        refetch: refetchFavorites,
    } = useQuery(GET_FAVORITES);

    // MUTATIONS
    const [addFavorite] = useMutation(ADD_FAVORITE);
    const [removeFavorite] = useMutation(REMOVE_FAVORITE);

    // STATES
    const [searchTerm, setSearchTerm] = useState("");
    const [filterType, setFilterType] = useState("");
    const [filterLocation, setFilterLocation] = useState("");
    const [showFavorites, setShowFavorites] = useState(false);
    const [isFilterOpen, setIsFilterOpen] = useState(false);

    const navigate = useNavigate();

    // FAVORITE IDS
    const favoriteIds = favoriteData?.myFavorites?.map(
        (fav) => Number(fav.job_id)
    ) || [];

    // TOGGLE FAVORITE
    const toggleFavorite = async (jobId, e) => {
        e.stopPropagation();

        try {
            if (favoriteIds.includes(Number(jobId))) {
                await removeFavorite({
                    variables: { job_id: jobId },
                });
            } else {
                await addFavorite({
                    variables: { job_id: jobId },
                });
            }
            refetchFavorites();
        } catch (err) {
            console.log(err);
        }
    };

    // CHECK FAVORITE
    const isFavorite = (jobId) => favoriteIds.includes(Number(jobId));

    // LOADING
    if (loading) {
        return (
            <div className="loading-state">
                <div className="loading-spinner"></div>
                <p>Finding the best opportunities for you...</p>
            </div>
        );
    }

    // ERROR
    if (error) {
        return (
            <div className="error-state">
                <i className="fas fa-exclamation-triangle"></i>
                <p>{error.message}</p>
                <button onClick={() => window.location.reload()}>Try Again</button>
            </div>
        );
    }

    // Get unique locations
    const uniqueLocations = [...new Set(data?.jobs.map((job) => job.location))];
    const uniqueJobTypes = [...new Set(data?.jobs.map((job) => job.job_type))];

    // FILTER JOBS
    const normalizedSearch = searchTerm.trim().toLowerCase();

    let filteredJobs = data?.jobs.filter((job) => {

        const title = job.title?.toLowerCase() || "";
        const company = job.company?.toLowerCase() || "";
        const location = job.location?.toLowerCase() || "";
        const description = job.description?.toLowerCase() || "";
        const skills = job.skills?.join(" ").toLowerCase() || "";

        const matchesSearch =
            title.includes(normalizedSearch) ||
            company.includes(normalizedSearch) ||
            location.includes(normalizedSearch) ||
            description.includes(normalizedSearch) ||
            skills.includes(normalizedSearch);

        const matchesType =
            !filterType || job.job_type === filterType;

        const matchesLocation =
            !filterLocation || job.location === filterLocation;

        return (
            matchesSearch &&
            matchesType &&
            matchesLocation
        );
    });

    // SHOW ONLY FAVORITES
    if (showFavorites) {
        filteredJobs = filteredJobs.filter((job) =>
            favoriteIds.includes(Number(job.id))
        );
    }

    // Format salary
    const formatSalary = (salary) => {
        if (salary >= 10000000) return `₹${(salary / 10000000).toFixed(1)}Cr`;
        if (salary >= 100000) return `₹${(salary / 100000).toFixed(1)}L`;
        return `₹${salary / 1000}K`;
    };

    // Get random gradient for company logo
    const getGradient = (company) => {
        const gradients = [
            "gradient-1", "gradient-2", "gradient-3", "gradient-4",
            "gradient-5", "gradient-6", "gradient-7", "gradient-8"
        ];
        const index = company.charCodeAt(0) % gradients.length;
        return gradients[index];
    };

    return (
        <div className="jobs-page">
            <div className="jobs-container">
                {/* HEADER SECTION */}
                <div className="page-header">
                    <div className="header-left">
                        <div className="header-badge">
                            <i className="fas fa-briefcase"></i>
                            <span>Job Board</span>
                        </div>
                        <h1>Find Your <span className="highlight">Dream Job</span></h1>
                        <p>Explore {data?.jobs.length}+ opportunities from top companies</p>
                    </div>

                    <button
                        className="post-job-btn"
                        onClick={() => window.location.href = "/add-job"}
                    >
                        <i className="fas fa-plus-circle"></i>
                        <span>Post a Job</span>
                    </button>
                </div>

                {/* SEARCH AND FILTER SECTION */}
                <div className="search-section">
                    <div className="search-main">
                        <div className="search-input-wrapper">
                            <i className="fas fa-search"></i>
                            <input
                                type="text"
                                placeholder="Search by title, company, or location..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                            {searchTerm && (
                                <button
                                    className="clear-search"
                                    onClick={() => setSearchTerm("")}
                                >
                                    <i className="fas fa-times-circle"></i>
                                </button>
                            )}
                        </div>

                        <button
                            className={`filter-toggle-btn ${isFilterOpen ? 'active' : ''}`}
                            onClick={() => setIsFilterOpen(!isFilterOpen)}
                        >
                            <i className="fas fa-sliders-h"></i>
                            <span>Filters</span>
                            {(filterType || filterLocation) && (
                                <span className="filter-badge"></span>
                            )}
                        </button>
                    </div>

                    {/* FILTER PANEL */}
                    {isFilterOpen && (
                        <div className="filter-panel">
                            <div className="filter-group">
                                <label>
                                    <i className="fas fa-briefcase"></i>
                                    Job Type
                                </label>
                                <div className="filter-options">
                                    <button
                                        className={`filter-chip ${!filterType ? 'active' : ''}`}
                                        onClick={() => setFilterType("")}
                                    >
                                        All
                                    </button>
                                    {uniqueJobTypes.map((type) => (
                                        <button
                                            key={type}
                                            className={`filter-chip ${filterType === type ? 'active' : ''}`}
                                            onClick={() => setFilterType(type)}
                                        >
                                            {type}
                                        </button>
                                    ))}
                                </div>
                            </div>

                            <div className="filter-group">
                                <label>
                                    <i className="fas fa-map-marker-alt"></i>
                                    Location
                                </label>
                                <div className="filter-options">
                                    <button
                                        className={`filter-chip ${!filterLocation ? 'active' : ''}`}
                                        onClick={() => setFilterLocation("")}
                                    >
                                        All
                                    </button>
                                    {uniqueLocations.map((loc) => (
                                        <button
                                            key={loc}
                                            className={`filter-chip ${filterLocation === loc ? 'active' : ''}`}
                                            onClick={() => setFilterLocation(loc)}
                                        >
                                            {loc}
                                        </button>
                                    ))}
                                </div>
                            </div>

                            <div className="filter-actions">
                                <button
                                    className="clear-filters-btn"
                                    onClick={() => {
                                        setFilterType("");
                                        setFilterLocation("");
                                    }}
                                >
                                    Clear All Filters
                                </button>
                            </div>
                        </div>
                    )}
                </div>

                {/* FAVORITES BAR */}
                <div className="favorites-section">
                    <button
                        className={`favorites-toggle ${showFavorites ? 'active' : ''}`}
                        onClick={() => setShowFavorites(!showFavorites)}
                    >
                        <i className={`fas ${showFavorites ? 'fa-star' : 'fa-star'}`}></i>
                        <span>{showFavorites ? 'Showing Favorites' : 'View Favorites'}</span>
                        {favoriteIds.length > 0 && (
                            <span className="favorites-count">{favoriteIds.length}</span>
                        )}
                    </button>
                </div>

                {/* RESULTS COUNT */}
                <div className="results-header">
                    <div className="results-count">
                        <i className="fas fa-list-ul"></i>
                        <span>Showing {filteredJobs?.length} {filteredJobs?.length === 1 ? 'job' : 'jobs'}</span>
                    </div>
                    {showFavorites && (
                        <button
                            className="clear-favorites"
                            onClick={() => setShowFavorites(false)}
                        >
                            <i className="fas fa-times"></i>
                            Clear Favorites
                        </button>
                    )}
                </div>

                {/* JOBS GRID */}
                {filteredJobs?.length > 0 ? (
                    <div className="jobs-grid">
                        {filteredJobs.map((job, index) => (
                            <div
                                key={job.id}
                                className="job-card"
                                onClick={() => navigate(`/jobs/${job.id}`)}
                                style={{ animationDelay: `${index * 0.05}s` }}
                            >
                                {/* CARD HEADER */}
                                <div className="job-card-header">
                                    <div className={`company-logo ${getGradient(job.company)}`}>
                                        {job.company.charAt(0).toUpperCase()}
                                    </div>

                                    <button
                                        className={`favorite-btn ${isFavorite(job.id) ? 'active' : ''}`}
                                        onClick={(e) => toggleFavorite(job.id, e)}
                                    >
                                        <i className={`${isFavorite(job.id) ? 'fas' : 'far'} fa-heart`}></i>
                                    </button>
                                </div>

                                {/* JOB TITLE & COMPANY */}
                                <div className="job-info">
                                    <h3 className="job-title">{job.title}</h3>
                                    <div className="company-name">
                                        <i className="fas fa-building"></i>
                                        <span>{job.company}</span>
                                    </div>
                                </div>

                                {/* JOB DETAILS */}
                                <div className="job-details">
                                    <div className="job-detail-item">
                                        <i className="fas fa-map-marker-alt"></i>
                                        <span>{job.location}</span>
                                    </div>
                                    <div className="job-detail-item">
                                        <i className="fas fa-rupee-sign"></i>
                                        <span>{formatSalary(job.salary)}</span>
                                    </div>
                                    <div className="job-detail-item">
                                        <i className="fas fa-clock"></i>
                                        <span>{job.job_type || 'Full Time'}</span>
                                    </div>
                                </div>

                                {/* DESCRIPTION */}
                                {/* <p className="job-description">
                                    {job.description.length > 120
                                        ? `${job.description.substring(0, 120)}...`
                                        : job.description}
                                </p> */}

                                {/* SKILLS */}
                                <div className="skills-wrapper">
                                    {job.skills?.slice(0, 4).map((skill, index) => (
                                        <span key={index} className="skill-badge">
                                            <i className="fas fa-code"></i>
                                            {skill}
                                        </span>
                                    ))}

                                    {job.skills?.length > 4 && (
                                        <span className="more-skills">
                                            +{job.skills.length - 4} more
                                        </span>
                                    )}
                                </div>

                                {/* CARD FOOTER */}
                                <div className="job-card-footer">
                                    <span className="job-type-badge">
                                        {job.job_type || 'Full Time'}
                                    </span>
                                    <button className="view-details-btn">
                                        <span>View Details</span>
                                        <i className="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="empty-results">
                        <div className="empty-icon">
                            <i className="fas fa-search"></i>
                        </div>
                        <h3>No jobs found</h3>
                        <p>Try adjusting your search or filters to find more opportunities</p>
                        <button
                            className="reset-filters-btn"
                            onClick={() => {
                                setSearchTerm("");
                                setFilterType("");
                                setFilterLocation("");
                                setShowFavorites(false);
                            }}
                        >
                            <i className="fas fa-redo-alt"></i>
                            Reset All Filters
                        </button>
                    </div>
                )}
            </div>
        </div>
    );
}