import './App.css';
import React, {useState, useEffect} from "react";
function App() {
  const apiUrl = "http://localhost:3000";
  const [bookmarks, setBookmarks] = useState([]); 
  const [title, setTitle] = useState(""); 
  const [link, setLink] = useState(""); 
  const [updateLink, setUpdateLink] = useState(""); 
  const [id, setId] = useState(null); 

  const fetchBookmarks = async () =>
    {
      const response = await fetch(`${apiUrl}/api/readAll.php`);
      const data = await response.json();
      setBookmarks(data);
    };

  useEffect(() => {

    fetchBookmarks(); }, 
    [id]);
    
  const createBookMark = async () => 
  {
      await fetch(`${apiUrl}/api/create.php`, {
      method: "POST",
      body: JSON.stringify({title, link}),
      headers: {'Content-Type': 'application/json',},
    });

    setTitle("");
    setLink("");
    fetchBookmarks();
  };

  const updateBookMark = async () =>
  {
    await fetch(`${apiUrl}/api/update.php`, {
      method: "PUT",
      body: JSON.stringify({id, link: updateLink}),
      headers: {'Content-Type': 'application/json',},

    });


    setUpdateLink("");
    fetchBookmarks();
  }

  const deleteBookMark = async (id) => 
  {
    const response = await fetch(`${apiUrl}/api/delete.php`, {
      method: 'DELETE',
      body: JSON.stringify({id }),
      headers: {'Content-Type': 'application/json',},
    });
    console.log(await response.json())
    fetchBookmarks();
  }

  return (
    <div className="App">
      <h1>Bookmark your links with titles</h1>
      <div>
        <input
        type = "text"
        placeholder="Title: "
        value={title}
        onChange={(e) => setTitle(e.target.value)}
        />
        <br></br>
        <input
        type = "text"
        placeholder="Link "
        value={link}
        onChange={(e) => setLink(e.target.value)}
        />
        <br></br>
        <button onClick={createBookMark}>
          Add Bookmark
        </button>
      </div>

      <div>
      <input
          type="text"
          placeholder="BookmarkID "
          value={id}
          onChange={(e) => setId(e.target.value)}
        />
        <br></br>
        <input
        type = "text"
        placeholder="Update Link "
        value={updateLink}
        onChange={(e) => setUpdateLink(e.target.value)}
        />
        <br></br>
        <button onClick={updateBookMark}>
          Update Bookmark
        </button>
      </div>

      <div>
        <h2>Bookmarks:</h2>
          {bookmarks.map((bookmark) => (
            <div key={bookmark.id}>
              <h3>Bookmark ID: {bookmark.id} <strong>{bookmark.title}</strong></h3>
              <a href={bookmark.link} target='_blank'>{bookmark.link}</a>
              <br/>
              <button onClick={() => deleteBookMark(bookmark.id)}>Delete</button>
            </div>
          )
        
        )}
      </div>
    </div>
  );
}

export default App;
