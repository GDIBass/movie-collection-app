import React     from 'react';
import PropTypes from 'prop-types';
import {
    Button,
    Well
}                from 'react-bootstrap';

export default function CollectionItem({
                                           collectionItem
                                       }) {
    return (

        <Well className="my-collection-item">
            <img
                className="my-collection-poster"
                src={ "https://image.tmdb.org/t/p/w185_and_h278_bestv2/" + collectionItem.poster_path }
            />
            <p>{ collectionItem.title }</p>
            <Button
                className="remove-collection-item"
                bsStyle="danger"
                type="button"
            >
                <i className="fa fa-trash"/>
            </Button>
            <Button
                className="collection-item-info"
                bsStyle="info"
                type="button"
            >
                <i className="fa fa-info"/>
            </Button>
        </Well>
    );
}

CollectionItem.propTypes = {
    collectionItem: PropTypes.object.isRequired
};
