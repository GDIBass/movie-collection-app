import React, { Component } from 'react';
import PropTypes            from 'prop-types';
import {
    Panel
}                           from 'react-bootstrap';
import CollectionItem       from "./CollectionItem";
import SearchGroup          from "./SearchGroup";

export default class Collection extends Component {
    constructor(props) {
        super(props);

        this.state = {
            collectionSearch     : '',
            collectionSearchInput: ''
        };

        this.handleClearSearch       = this.handleClearSearch.bind(this);
        this.handleClickSearch       = this.handleClickSearch.bind(this);
        this.handleSearchInputChange = this.handleSearchInputChange.bind(this);
    }

    /**
     * Clear the search field
     */
    handleClearSearch() {
        this.setState({
            collectionSearch     : '',
            collectionSearchInput: ''

        });
    }

    /**
     * Proceed with the search
     */
    handleClickSearch() {
        this.setState({
            collectionSearch: this.state.collectionSearchInput
        });
    }

    /**
     * Handle search input change
     *
     * @param event
     */
    handleSearchInputChange(event) {
        this.setState({
            collectionSearchInput: event.target.value
        });
    }

    render() {
        const { collection, handleShowDetails, handleToggleMovieInCollection, updating } = this.props;

        let filteredCollection = [...collection];

        const search = this.state.collectionSearch;
        if ( search !== '' ) {
            filteredCollection = filteredCollection.filter(item => {
                return (
                    item.title.search(search) !== -1
                    ||
                    item.overview.search(search) !== -1
                );
            });
        }

        return (
            <div id="my-collection">
                <h2>My Collection</h2>
                <Panel>
                    <Panel.Heading>
                        <SearchGroup
                            className="mb-0"
                            handleClearSearch={ this.handleClearSearch }
                            handleClickSearch={ this.handleClickSearch }
                            handleSearchInputChange={ this.handleSearchInputChange }
                            search={ this.state.collectionSearch }
                            searchInput={ this.state.collectionSearchInput }
                            searchPlaceholder="Search My Collection"
                            type={ "collection" }
                        />
                    </Panel.Heading>
                    <Panel.Body className="my-collection">
                        {
                            filteredCollection.map((collectionItem, key) =>
                                <CollectionItem
                                    collectionItem={ collectionItem }
                                    handleShowDetails={ handleShowDetails }
                                    handleToggleMovieInCollection={ handleToggleMovieInCollection }
                                    key={ key }
                                    updating={ updating.indexOf(collectionItem.id) !== - 1 }
                                />
                            )
                        }
                        <div className="right-box">'</div>
                    </Panel.Body>
                </Panel>
            </div>
        );
    }
}

Collection.propTypes = {
    collection                   : PropTypes.array.isRequired,
    handleShowDetails            : PropTypes.func.isRequired,
    handleToggleMovieInCollection: PropTypes.func.isRequired,
    updating                     : PropTypes.array.isRequired
};
