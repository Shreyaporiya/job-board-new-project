import { useState } from "react";
import { gql, useMutation } from "@apollo/client";

const CREATE_POST = gql`
  mutation CreatePost($title: String!, $content: String!) {
    createPost(title: $title, content: $content) {
      id
      title
      content
    }
  }
`;

export default function AddPost() {
  const [title, setTitle] = useState("");
  const [content, setContent] = useState("");

  const [createPost, { loading, error }] = useMutation(CREATE_POST);

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      await createPost({
        variables: {
          title,
          content,
        },
      });

      alert("Post Added");

      setTitle("");
      setContent("");
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <input
        type="text"
        placeholder="Title"
        value={title}
        onChange={(e) => setTitle(e.target.value)}
      />

      <textarea
        placeholder="Content"
        value={content}
        onChange={(e) => setContent(e.target.value)}
      />

      <button type="submit">
        {loading ? "Adding..." : "Add Post"}
      </button>

      {error && <p>Error adding post</p>}
    </form>
  );
}