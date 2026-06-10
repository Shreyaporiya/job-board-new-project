import { useState } from "react";
import { gql, useMutation } from "@apollo/client";

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

export default function EditPost({ post }) {
  const [editing, setEditing] = useState(false);

  const [form, setForm] = useState({
    title: post.title,
    content: post.content,
  });

  const [updatePost] = useMutation(UPDATE_POST);

  const handleUpdate = async () => {
    try {
      await updatePost({
        variables: {
          id: post.id,
          title: form.title,
          content: form.content,
        },
      });

      alert("Post Updated");

      window.location.reload();
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <div>
      {editing ? (
        <>
          <input
            type="text"
            value={form.title}
            onChange={(e) =>
              setForm({
                ...form,
                title: e.target.value,
              })
            }
          />

          <br />
          <br />

          <textarea
            value={form.content}
            onChange={(e) =>
              setForm({
                ...form,
                content: e.target.value,
              })
            }
          />

          <br />
          <br />

          <button onClick={handleUpdate}>
            Save
          </button>

          <button onClick={() => setEditing(false)}>
            Cancel
          </button>
        </>
      ) : (
        <button onClick={() => setEditing(true)}>
          Edit
        </button>
      )}
    </div>
  );
}