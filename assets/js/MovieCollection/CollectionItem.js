import React     from 'react';
import PropTypes from 'prop-types';
import {
    Button,
    Well
}                from 'react-bootstrap';

export default function CollectionItem({
                                           collectionItem,
                                           handleShowDetails,
                                           handleToggleMovieInCollection,
                                           updating
                                       }) {

    let img;
    if ( ! collectionItem.poster_path ) {
        img = (
            <svg width="150" height="225" className="img-placeholder-container">
                <rect width="150" height="225" className="img-placeholder"/>
            </svg>
        );
    } else {
        img = (
            <img
                className="my-collection-poster"
                src={ "https://image.tmdb.org/t/p/w185_and_h278_bestv2/" + collectionItem.poster_path }
            />
        );
    }
    return (

        <Well className="my-collection-item">
            { img }
            <p>{ collectionItem.title }</p>
            <Button
                bsStyle="info"
                className="collection-item-info"
                disabled={ updating }
                onClick={ () => handleShowDetails(collectionItem) }
                title="More Information"
                type="button"
            >
                <i className="fa fa-info"/>
            </Button>
            <Button
                bsStyle="danger"
                className="remove-collection-item"
                disabled={ updating }
                onClick={ () => handleToggleMovieInCollection(collectionItem) }
                title="Remove from my collection"
                type="button"
            >
                <i className="fa fa-trash"/>
            </Button>
        </Well>
    );
}

CollectionItem.propTypes = {
    collectionItem               : PropTypes.object.isRequired,
    handleToggleMovieInCollection: PropTypes.func.isRequired,
    updating                     : PropTypes.bool.isRequired
};
