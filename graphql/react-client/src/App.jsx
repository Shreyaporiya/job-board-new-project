import AddPost from "./Addposts";
import Posts from "./Posts";

function App() {
  return (
    <div>
      <h1>GraphQL CRUD App</h1>

      <AddPost />

      <hr />

      <Posts />
    </div>
  );
}

export default App;