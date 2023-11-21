import React, { useState, useEffect } from "react";
function Index() {
    const [news, setNews] = useState([]);

    useEffect(() => {
        fetch("https://jsonplaceholder.typicode.com/posts")
            .then((response) => response.json())
            .then((json) => setNews(json));
    }, []);

    return;
}

export default Index;
