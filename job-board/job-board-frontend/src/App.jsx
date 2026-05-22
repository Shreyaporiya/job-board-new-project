import {
  Routes,
  Route,
} from "react-router-dom";

import Header from "./components/Header";
import Footer from "./components/Footer";

import JobList from "./components/JobList";
import AddJob from "./components/AddJob";
import JobDetails from "./components/JobDetails";

import Login from "./components/Login";
import Register from "./components/Register";
import Profile from "./components/Profile";
import ForgotPassword from "./components/ForgotPassword";
import ResetPassword from "./components/ResetPassword";

import ProtectedRoute from "./components/ProtectedRoute";

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

import "./App.css";

export default function App() {
  return (
    <>
      <Header />

      <main
        style={{
          padding: "20px",
          minHeight: "80vh",
          backgroundColor: "#f8fafc",
        }}
      >
        <Routes>

          {/* Protected Routes */}

          <Route
            path="/"
            element={
              <ProtectedRoute>
                <JobList />
              </ProtectedRoute>
            }
          />

          <Route
            path="/jobs/:id"
            element={
              <ProtectedRoute>
                <JobDetails />
              </ProtectedRoute>
            }
          />

          <Route
            path="/add-job"
            element={
              <ProtectedRoute>
                <AddJob />
              </ProtectedRoute>
            }
          />

          <Route
            path="/profile"
            element={
              <ProtectedRoute>
                <Profile />
              </ProtectedRoute>
            }
          />

          {/* Public Routes */}

          <Route
            path="/login"
            element={<Login />}
          />

          <Route
            path="/register"
            element={<Register />}
          />

          <Route
            path="/forgot-password"
            element={<ForgotPassword />}
          />
          <Route
            path="/reset-password"
            element={<ResetPassword />}
          />
        </Routes>
      </main>

      <Footer />
    </>
  );
}