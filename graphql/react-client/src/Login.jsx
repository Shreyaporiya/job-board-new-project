import { useState } from "react";
import { gql, useMutation } from "@apollo/client";

const LOGIN = gql`
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

export default function Login() {

    const [form, setForm] = useState({
        email: "",
        password: "",
    });

    const [message, setMessage] = useState("");

    const [login] = useMutation(LOGIN);

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            const { data } = await login({
                variables: form,
            });

            console.log(data);

            localStorage.setItem(
                "user",
                JSON.stringify(data.login.user)
            );

            // SAVE TOKEN ALSO
            localStorage.setItem(
                "token",
                data.login.token
            );

            setMessage("Login Successful");

            window.location.reload();

        } catch (error) {

            console.log(error); // ADD HERE

            setMessage(error.message);
        }
    };

    return (
        <div>

            <h1>Login</h1>

            <form onSubmit={handleSubmit}>

                <input
                    type="email"
                    placeholder="Email"
                    value={form.email}
                    onChange={(e) =>
                        setForm({
                            ...form,
                            email: e.target.value,
                        })
                    }
                />

                <br />
                <br />

                <input
                    type="password"
                    placeholder="Password"
                    value={form.password}
                    onChange={(e) =>
                        setForm({
                            ...form,
                            password: e.target.value,
                        })
                    }
                />

                <br />
                <br />

                <button type="submit">
                    Login
                </button>

            </form>

            <p>{message}</p>

        </div>
    );
}