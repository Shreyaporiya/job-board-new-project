import {
    useQuery,
    useMutation,
} from "@apollo/client";

import { GET_FAVORITES, REMOVE_FAVORITE } from "./queries";

export default function FavoriteJobs() {

    const {
        data,
        loading,
        error,
        refetch,
    } = useQuery(GET_FAVORITES);

    const [removeFavorite] =
        useMutation(REMOVE_FAVORITE);

    if (loading)
        return <p>Loading...</p>;

    if (error)
        return <p>{error.message}</p>;

    const handleRemove =
        async (jobId) => {

            await removeFavorite({
                variables: {
                    job_id: jobId,
                },
            });

            refetch();
        };

    return (
        <div>

            <h1>Favorite Jobs</h1>

            {data.me.favoriteJobs.length ===
                0 && (
                    <p>
                        No Favorite Jobs
                    </p>
                )}

            {data.me.favoriteJobs.map(
                (job) => (

                    <div
                        key={job.id}
                        style={cardStyle}
                    >
                        <h2>
                            {job.title}
                        </h2>

                        <p>
                            {job.company}
                        </p>

                        <p>
                            {job.location}
                        </p>

                        <p>
                            ₹{job.salary}
                        </p>

                        <button
                            onClick={() =>
                                handleRemove(
                                    job.id
                                )
                            }
                            style={
                                buttonStyle
                            }
                        >
                            Remove Favorite
                        </button>
                    </div>
                )
            )}
        </div>
    );
}

const cardStyle = {
    background: "#fff",
    padding: "20px",
    marginBottom: "20px",
    borderRadius: "10px",
};

const buttonStyle = {
    padding: "10px 15px",
    backgroundColor: "red",
    color: "#fff",
    border: "none",
    cursor: "pointer",
};