import React     from 'react';
import PropTypes from 'prop-types';
import {
    Button,
    Col,
    Row,
    Well
}                from 'react-bootstrap';

export default function Result({
                                   handleClickAddRemoveFromCollection,
                                   inCollection,
                                   result,
                                   updating
                               }) {
    let buttonText = ( inCollection ? "Remove From" : "Add To" ) + " My Collection";

    let buttonView = updating ?
                     (
                         <span>
                             <i className="fa fa-spinner faa-spin animated"/> { buttonText }
                         </span>
                     ) :
                     buttonText;

    let img;
    if ( ! result.poster_path ) {
        img = (
            <svg width="150" height="200">
                <rect width="150" height="200" className="img-placeholder"/>
            </svg>
        );
    }
    else {
        img = ( <img
            className="result-poster"
            src={ "https://image.tmdb.org/t/p/w185_and_h278_bestv2/" + result.poster_path }
        /> );
    }

    return (
        <Well className="moviedb-result" data-id={ result.id }>
            <Row>
                <Col xs={ 2 }>
                    { img }
                </Col>
                <Col xs={ 10 }>
                    <h3>{ result.title }</h3>
                    <p>Released: { result.release_date }</p>
                    <p>{ result.overview }</p>
                    <Button
                        bsStyle={ inCollection ? 'danger' : 'success' }
                        className={ "toggle-collection search-toggle-collection-" + result.id + (updating ? ' data-updating' : '')}
                        data-in-collection={ inCollection }
                        disabled={ updating }
                        onClick={ () => handleClickAddRemoveFromCollection(result) }
                    >
                        { buttonView }
                    </Button>
                </Col>
            </Row>
        </Well>
    );
}

Result.propTypes = {
    handleClickAddRemoveFromCollection: PropTypes.func.isRequired,
    inCollection                      : PropTypes.bool.isRequired,
    result                            : PropTypes.object.isRequired,
    updating                          : PropTypes.bool.isRequired
};