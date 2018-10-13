import React, { Component } from 'react';
import PropTypes            from 'prop-types';
import Collection           from "./Collection";
import {
    Grid, Row
}                           from 'react-bootstrap';
import Search               from "./Search";
import NavMenu              from "./NavMenu";
import Api                  from '../Api/Api';
import swal                 from 'sweetalert2';
import DetailsModal         from "./DetailsModal";

const loadingSwal = (title = null) => {
    swal({
        title            : title,
        showConfirmButton: false,
        allowOutsideClick: false,
        html             : '<i class="fa fa-th-large fa-5 fa-spinner faa-spin animated" style="font-size:100px;"/>'
    });
};

export default class MovieCollectionApp extends Component {
    constructor(props) {
        super(props);

        const { collection } = props;

        MovieCollectionApp.sortCollection(collection);

        this.state = {
            collection   : collection,
            details      : null,
            search       : '',
            searchLoading: false,
            searchResults: null,
            updating     : []
        };

        this.setOrUnsetUpdating            = this.setOrUnsetUpdating.bind(this);
        this.addOrRemoveFromCollection     = this.addOrRemoveFromCollection.bind(this);
        this.handleShowDetails             = this.handleShowDetails.bind(this);
        this.handleToggleMovieInCollection = this.handleToggleMovieInCollection.bind(this);
        this.handleUpdateSearch            = this.handleUpdateSearch.bind(this);
    }

    /**
     * Sort a collection
     *
     * @param collection
     */
    static sortCollection(collection) {
        collection.sort((a, b) => {
            if ( a.title < b.title ) {
                return - 1;
            }
            if ( a.title > b.title ) {
                return 1;
            }
            return 0;
        });
    }

    /**
     * Set or unset the updating field
     *
     * @param set
     * @param movieId
     */
    setOrUnsetUpdating(set, movieId) {
        this.setState(prevState => {
            let newUpdating = [...prevState.updating];
            if ( set ) {
                newUpdating.push(movieId);
            }
            else {
                newUpdating = newUpdating.filter(v => v !== movieId);
            }
            return {
                updating: newUpdating
            };
        });
    }

    /**
     * Add or remove from our collection
     *
     * @param remove
     * @param movie
     */
    addOrRemoveFromCollection(remove, movie) {
        this.setState(prevState => {
            let newCollection = [...prevState.collection];

            if ( remove ) {
                newCollection = newCollection.filter(v => v.id !== movie.id);
            }
            else {
                newCollection.push(movie);
                newCollection.sort((a, b) => a.title - b.title);
            }
            MovieCollectionApp.sortCollection(newCollection);
            return {
                collection: newCollection
            };
        });
    }

    /**
     * Opens or closes the movie detail modal
     *
     * @param movie
     */
    handleShowDetails(movie) {
        this.setState({
            details: movie
        });
    }

    /**
     * Add or remove movie from collection
     *
     * @param movie
     */
    handleToggleMovieInCollection(movie) {
        const inCollection = this.state.collection.filter(
            collectionMovie => collectionMovie.id === movie.id
        ).length > 0;

        this.setOrUnsetUpdating(true, movie.id);
        const self = this;
        Api.addRemoveFromCollection(inCollection, movie.id).then(() => {
            self.addOrRemoveFromCollection(inCollection, movie);
            self.setOrUnsetUpdating(false, movie.id);
        }).catch(() => {
            self.setOrUnsetUpdating(false, movie.id);
        });
    }

    /**
     * Updates the search query, sending an API request if a query is included
     *
     * @param query
     */
    handleUpdateSearch(query) {
        // If the query is null then wipe out all searches
        if ( query === '' ) {
            this.setState({
                search       : '',
                searchLoading: false,
                searchResults: null,
            });
            return;
        }

        // Set loading
        this.setState({
            searchLoading: true
        });

        // Send Api Request
        const self = this;
        Api.movieSearch(query).then((response) => {
            // Update results
            self.setState({
                search       : query,
                searchLoading: false,
                searchResults: response
            })
        }).catch(() => {
            // Catch an error and display a sweet alert
            self.setState({
                searchLoading: false
            });
            swal({
                type : "Error",
                title: "Uh oh",
                html : "Something went wrong, please try again later."
            });
        });
    }

    render() {
        return (
            <div>
                <NavMenu/>
                <main>
                    <Grid>
                        <Row>
                            <Search
                                collection={ this.state.collection }
                                handleToggleMovieInCollection={ this.handleToggleMovieInCollection }
                                handleUpdateSearch={ this.handleUpdateSearch }
                                search={ this.state.search }
                                searchLoading={ this.state.searchLoading }
                                searchResults={ this.state.searchResults }
                                updating={ this.state.updating }
                            />
                        </Row>
                        <Row>
                            <Collection
                                collection={ this.state.collection }
                                handleShowDetails={ this.handleShowDetails }
                                handleToggleMovieInCollection={ this.handleToggleMovieInCollection }
                                updating={ this.state.updating }
                            />
                        </Row>
                    </Grid>
                </main>
                <DetailsModal
                    details={ this.state.details }
                    handleShowDetails={ this.handleShowDetails }
                    handleToggleMovieInCollection={ this.handleToggleMovieInCollection }
                    inCollection={
                        this.state.collection.indexOf(this.state.details) !== -1
                    }
                    updating={ this.state.updating.indexOf(this.state.details) !== -1 }
                />
            </div>
        );
    }
}

MovieCollectionApp
    .propTypes = {
    collection: PropTypes.array.isRequired
};


