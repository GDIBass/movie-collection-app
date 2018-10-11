import React     from 'react';
import PropTypes from 'prop-types';
import {
    Button,
    Col,
    Row,
    Well
}                from 'react-bootstrap';

export default function Result({
                                   result
                               }) {

    return (
        <Well className="moviedb-result">
            <Row>
                <Col xs={ 2 }>
                    <img
                        className="result-poster"
                        src={ "https://image.tmdb.org/t/p/w185_and_h278_bestv2/" + result.poster_path }
                    />
                </Col>
                <Col xs={ 10 }>
                    <h3>{ result.title }</h3>
                    <p>{ result.release_date }</p>
                    <p>{ result.overview }</p>
                    <Button
                        bsStyle="danger"
                    >
                        Remove From My Collection
                    </Button>
                </Col>
            </Row>
        </Well>
    );
}

Result.propTypes = {
    result: PropTypes.object.isRequired
};