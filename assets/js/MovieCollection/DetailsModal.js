import React     from "react";
import PropTypes from 'prop-types';
import {
    Button, Col,
    Modal
}                from 'react-bootstrap';

export default function DetailsModal({
                                         details,
                                         handleShowDetails,
                                         handleToggleMovieInCollection,
                                         inCollection,
                                         updating
                                     }) {
    if ( ! details ) {
        return <span/>;
    }

    let buttonText = ( inCollection ? "Remove From" : "Add To" ) + " My Collection";

    let buttonView = updating ?
                     (
                         <span>
                             <i className="fa fa-spinner faa-spin animated"/> { buttonText }
                         </span>
                     ) :
                     buttonText;

    let img;

    if ( ! details.poster_path ) {
        img = (
            <svg width="150" height="225" className="img-placeholder-container modal-poster">
                <rect width="150" height="225" className="img-placeholder"/>
            </svg>
        );
    }
    else {
        img = (
            <img
                className="modal-poster"
                src={ "https://image.tmdb.org/t/p/w185_and_h278_bestv2/" + details.poster_path }
            />
        );
    }

    return (
        <Modal
            className="details-modal"
            onHide={ () => handleShowDetails(null) }
            show={ details !== null }
        >
            <Modal.Header>
                <Modal.Title>{ details.title }</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                { img }
                <p>Released: { details.release_date }</p>
                <p>{ details.overview }</p>
            </Modal.Body>
            <Modal.Footer>
                <Button
                    bsStyle={ inCollection ? 'danger' : 'success' }
                    disabled={ updating }
                    onClick={ () => handleToggleMovieInCollection(details) }
                >
                    { buttonView }
                </Button>
                <Button onClick={ () => handleShowDetails(null) }>Close</Button>
            </Modal.Footer>
        </Modal>
    );
}

DetailsModal.propTypes = {
    details                      : PropTypes.object,
    handleShowDetails            : PropTypes.func.isRequired,
    handleToggleMovieInCollection: PropTypes.func.isRequired,
    inCollection                 : PropTypes.bool,
    updating                     : PropTypes.bool
};