import React, { Component } from 'react';
import PropTypes            from 'prop-types';
import {
    Panel
}                           from 'react-bootstrap';
import Result               from "./Result";
import SearchGroup          from "./SearchGroup";

function PanelBody({
                       collection,
                       handleClickAddRemoveFilter,
                       results,
                       searchLoading,
                       total,
                       updating
                   }) {
    if ( ! searchLoading ) {
        return (
            <Panel.Body className="moviedb-search">
                {
                    results.map((item, key) =>

                        <Result
                            inCollection={
                                collection.filter(
                                    collectionMovie => collectionMovie.id === item.id
                                ).length > 0
                            }
                            handleClickAddRemoveFromCollection={ handleClickAddRemoveFilter }
                            key={ key }
                            result={ item }
                            updating={ updating.indexOf(item.id) !== -1 }
                        />
                    )
                }
                <div>
                    { total }
                </div>
            </Panel.Body>
        )
    }
    else {
        return (
            <Panel.Body className="moviedb-search text-center search-loading-movie">
                <i className="fa fa-th-large fa-2x fa-spinner faa-spin animated"/>
            </Panel.Body>
        );
    }
}

PanelBody.propTypes = {
    collection                : PropTypes.array.isRequired,
    handleClickAddRemoveFilter: PropTypes.func.isRequired,
    results                   : PropTypes.array.isRequired,
    searchLoading             : PropTypes.bool.isRequired,
    total                     : PropTypes.string.isRequired,
    updating                  : PropTypes.array.isRequired
};

export default class Search extends Component {
    constructor(props) {
        super(props);

        const { search } = props;

        this.state = {
            searchInput: search
        };

        this.handleClickAddRemoveFromCollection = this.handleClickAddRemoveFromCollection.bind(this);
        this.handleClearSearch                  = this.handleClearSearch.bind(this);
        this.handleClickSearch                  = this.handleClickSearch.bind(this);
        this.handleSearchInputChange            = this.handleSearchInputChange.bind(this);
    }

    /**
     * Toggles adding / removing a movie from user's collection
     *
     * @param movie
     */
    handleClickAddRemoveFromCollection(movie) {
        const { handleToggleMovieInCollection } = this.props;
        handleToggleMovieInCollection(movie);
    }

    /**
     * Clear the search field
     */
    handleClearSearch() {
        this.setState({
            searchInput: ''
        }, this.handleClickSearch);
    }

    /**
     * Proceed with the search
     */
    handleClickSearch() {
        const { handleUpdateSearch } = this.props;
        handleUpdateSearch(this.state.searchInput);
    }

    /**
     * Handle search input change
     *
     * @param event
     */
    handleSearchInputChange(event) {
        this.setState({
            searchInput: event.target.value
        });
    }

    render() {

        const { collection, search, searchLoading, searchResults, updating } = this.props;

        const results = searchResults ? searchResults.results : [];
        const total   = searchResults ?
                        searchResults.total_results + ' Total Results' :
                        'No Results';


        return (
            <div id="search">
                <h2>Search All Movies</h2>
                <Panel>
                    <Panel.Heading>
                        <SearchGroup
                            handleClearSearch={ this.handleClearSearch }
                            handleClickSearch={ this.handleClickSearch }
                            handleSearchInputChange={ this.handleSearchInputChange }
                            search={ search }
                            searchInput={ this.state.searchInput }
                            searchPlaceholder={ "Search for Movies" }
                            type={ "movie" }
                        />
                    </Panel.Heading>
                    <PanelBody
                        collection={ collection }
                        handleClickAddRemoveFilter={ this.handleClickAddRemoveFromCollection }
                        searchLoading={ searchLoading }
                        results={ results }
                        total={ total }
                        updating={ updating }
                    />
                </Panel>
            </div>
        );
    }
}

Search.propTypes = {
    collection                   : PropTypes.array.isRequired,
    handleToggleMovieInCollection: PropTypes.func.isRequired,
    handleUpdateSearch           : PropTypes.func.isRequired,
    search                       : PropTypes.string,
    searchLoading                : PropTypes.bool.isRequired,
    searchResults                : PropTypes.object,
    updating                     : PropTypes.array.isRequired
};
