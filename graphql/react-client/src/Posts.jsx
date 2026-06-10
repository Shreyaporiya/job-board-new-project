import { useState } from "react";

import {
    gql,
    useQuery,
    useMutation,
} from "@apollo/client";

export const GET_POSTS = gql`
  query {
    posts {
      id
      title
      content
    }
  }
`;

const UPDATE_POST = gql`
  mutation UpdatePost(
    $id: ID!
    $title: String!
    $content: String!
  ) {
    updatePost(
      id: $id
      title: $title
      content: $content
    ) {
      id
      title
      content
    }
  }
`;

const DELETE_POST = gql`
  mutation DeletePost($id: ID!) {
    deletePost(id: $id) {
      id
    }
  }
`;

export default function Posts() {
    const { loading, error, data } =
        useQuery(GET_POSTS);

    const [editingId, setEditingId] =
        useState(null);

    const [title, setTitle] = useState("");
    const [content, setContent] = useState("");

    const [updatePost] = useMutation(
        UPDATE_POST,
        {
            refetchQueries: [{ query: GET_POSTS }],
        }
    );

    const [deletePost] = useMutation(
        DELETE_POST,
        {
            refetchQueries: [{ query: GET_POSTS }],
        }
    );

    if (loading) return <p>Loading...</p>;

    if (error) return <p>Error loading posts</p>;

    const startEdit = (post) => {
        setEditingId(post.id);
        setTitle(post.title);
        setContent(post.content);
    };

    const handleUpdate = async () => {
        await updatePost({
            variables: {
                id: editingId,
                title,
                content,
            },
        });

        setEditingId(null);
        setTitle("");
        setContent("");
    };

    const handleDelete = async (id) => {
        await deletePost({
            variables: {
                id,
            },
        });
    };

    return (
        <div>
            <h2>All Posts</h2>

            {data.posts.map((post) => (
                <div
                    key={post.id}
                    style={{
                        border: "1px solid gray",
                        padding: "10px",
                        marginBottom: "10px",
                    }}
                >
                    {editingId === post.id ? (
                        <>
                            <input
                                type="text"
                                value={title}
                                onChange={(e) =>
                                    setTitle(e.target.value)
                                }
                            />

                            <br />
                            <br />

                            <textarea
                                value={content}
                                onChange={(e) =>
                                    setContent(e.target.value)
                                }
                            />

                            <br />
                            <br />

                            <button onClick={handleUpdate}>
                                Save
                            </button>

                            <button
                                onClick={() =>
                                    setEditingId(null)
                                }
                            >
                                Cancel
                            </button>
                        </>
                    ) : (
                        <>
                            <h3>{post.title}</h3>

                            <p>{post.content}</p>

                            <button
                                onClick={() =>
                                    startEdit(post)
                                }
                            >
                                Edit
                            </button>

                            <button
                                onClick={() =>
                                    handleDelete(post.id)
                                }
                            >
                                Delete
                            </button>
                        </>
                    )}
                </div>
            ))}
        </div>
    );
}