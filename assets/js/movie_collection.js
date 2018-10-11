// Our SCSS files, including the bootstrap styling
import 'bootstrap/dist/css/bootstrap.css';
import '../scss/movie_collection.scss';
import 'font-awesome-sass/assets/stylesheets/_font-awesome.scss';
// Javascript
import React              from 'react';
import { render }         from 'react-dom';
import MovieCollectionApp from "./MovieCollection/MovieCollectionApp";

render(
    <MovieCollectionApp
        { ...window.MOVIE_COLLECTION_PROPS }
    />,
    document.getElementById('movie-collection-app')
);