import { useState } from "react";
import { gql, useMutation } from "@apollo/client";

const CREATE_POST = gql`
  mutation CreatePost(
    $title: String!
    $content: String!
  ) {
    createPost(
      title: $title
      content: $content
    ) {
      id
      title
      content
    }
  }
`;

export default function AddPost() {
    const [form, setForm] = useState({
        title: "",
        content: "",
    });

    const [createPost] = useMutation(CREATE_POST);

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            await createPost({
                variables: form,
            });

            alert("Post Added");

            window.location.reload();
        } catch (error) {
            console.log(error);
        }
    };

    return (
        <div>
            <h2>Add Post</h2>

            <form onSubmit={handleSubmit}>
                <input
                    type="text"
                    placeholder="Title"
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
                    placeholder="Content"
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

                <button type="submit">
                    Add Post
                </button>
            </form>
        </div>
    );
}