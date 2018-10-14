import PropTypes from "prop-types";
import React     from "react";

export default function InCollectionBadge({ inCollection }) {
    if ( inCollection ) {
        return (
            <div className="result-in-collection">
                <i className="fa fa-check fa-3x"/>
            </div>
        );
    }

    return ( <span/> );
}

InCollectionBadge.propTypes = {
    inCollection: PropTypes.bool.isRequired
};