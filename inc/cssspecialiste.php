<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            margin-top: -5pc;
            color: #333;
            margin-left: 9pc;
            font-size: large;
        }
        
        p{
            font-size: small;
            color: blue;
            margin-left: 9pc;
        }
        ul {
    list-style-type: none;
    padding: 0;
    display: grid;
    grid: 12px;
    grid-template-columns: repeat(3, 1fr);
    
}

li {
    margin: 10px; /* Espacement entre les éléments */
    flex: 1 1 calc(25% - 20px); /* Pour avoir 4 éléments par ligne, ajustez selon vos besoins */
    box-sizing: border-box;
    
}

.card {
    width: 100%; 
            max-width: 300px; 
            
}

        li:hover {
            background: #eaeaea;
        }
        
        img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 2px solid #4CAF50;
    margin-left: 2pc;
    margin-top: 2pc;
}
        p {
            color: #666;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        .buttons {
            margin-top: 4pc;
            display: flex;
            gap: 16px;
        }
        .button {
          
            padding: 8px 15px;
            background-color: hsl(158, 97%, 29%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            width: 12pc;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>