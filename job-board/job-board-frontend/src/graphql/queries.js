import { gql } from "@apollo/client";

export const GET_JOBS = gql`
    query {
        jobs {
            id
            title
            company
            description
            location
            salary
            skills
            responsibilities
            job_type

            user {
                id
                name
            }
        }
    }
`;

export const ADD_FAVORITE = gql`
    mutation($job_id: ID!) {
        addFavorite(job_id: $job_id) {
            id
        }
    }
`;

export const CREATE_JOB = gql`
    mutation CreateJob(
        $title: String!
        $company: String!
        $description: String!
        $location: String!
        $salary: String!
        $skills: [String!]!
        $responsibilities: [String!]!
        $job_type: String!
    ) {
        createJob(
            title: $title
            company: $company
            description: $description
            location: $location
            salary: $salary
            skills: $skills
            responsibilities: $responsibilities
            job_type: $job_type
        ) {
            id
            title
        }
    }
`;

export const GET_JOB = gql`
    query($id: ID!) {
        job(id: $id) {
            id
            title
            company
            description
            location
            salary
            skills
            responsibilities
            job_type
            user {
                name
                email
            }
        }
    }
`;

export const RESET_PASSWORD = gql`
  mutation ResetPassword(
    $email: String!
    $token: String!
    $password: String!
  ) {
    resetPassword(
      email: $email
      token: $token
      password: $password
    )
  }
`;

export const GET_ME = gql`
  query {
    me {
      id
      name
      email
      jobs {
        id
        title
        company
        description
        location
        salary
        skills
        responsibilities
        job_type
      }
    }
  }
`;

export const UPDATE_PROFILE = gql`
  mutation UpdateProfile(
    $name: String!
    $email: String!
    $password: String
  ) {
    updateProfile(
      name: $name
      email: $email
      password: $password
    ) {
      id
      name
      email
    }
  }
`;

export const DELETE_PROFILE = gql`
  mutation {
    deleteProfile
  }
`;

export const UPDATE_JOB = gql`
  mutation UpdateJob(
    $id: ID!
    $title: String!
    $company: String!
    $description: String!
    $location: String!
    $salary: String!
    $skills: [String!]!
    $responsibilities: [String!]!
    $job_type: String!
  ) {
    updateJob(
      id: $id
      title: $title
      company: $company
      description: $description
      location: $location
      salary: $salary
      skills: $skills
      responsibilities: $responsibilities
      job_type: $job_type
    ) {
      id
      title
    }
  }
`;

export const DELETE_JOB = gql`
  mutation DeleteJob($id: ID!) {
    deleteJob(id: $id)
  }
`;

export const GET_FAVORITES = gql`
    query {
        me {
            favoriteJobs {
                id
                title
                company
                location
                salary
            }
        }
    }
`;

export const REMOVE_FAVORITE = gql`
    mutation RemoveFavorite(
        $job_id: ID!
    ) {
        removeFavorite(
            job_id: $job_id
        )
    }
`;

export const REGISTER = gql`
  mutation Register($name: String!, $email: String!, $password: String!) {
    register(name: $name, email: $email, password: $password) {
      token
      user {
        id
        name
        email
      }
    }
  }
`;

export const FORGOT_PASSWORD = gql`
  mutation ForgotPassword($email: String!) {
    forgotPassword(email: $email)
  }
`;

export const LOGIN = gql`
  mutation Login($email: String!, $password: String!) {
    login(email: $email, password: $password) {
      token
      user {
        id
        name
        email
      }
    }
  }
`;