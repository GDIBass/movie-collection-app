import React                        from 'react';
import PropTypes                    from 'prop-types';
import { Button, Form, InputGroup } from "react-bootstrap";

export default function SearchGroup({
                                        handleClearSearch,
                                        handleClickSearch,
                                        handleSearchInputChange,
                                        search,
                                        searchInput,
                                        searchPlaceholder
                                    }) {

    return (

        <span className="input-group"
              onKeyPress={
                  (e) => e.key === 'Enter' ? handleClickSearch() : null
              }
        >
            <input
                className="form-control"
                onChange={ handleSearchInputChange }
                placeholder={ searchPlaceholder }
                type="text"
                value={ searchInput }
            />
            <InputGroup.Button>
                <Button
                    bsStyle="info"
                    disabled={ search === searchInput }
                    onClick={ () => {
                        if ( search !== searchInput ) {
                            handleClickSearch();
                        }
                    } }
                    title="Go!"
                    type="button"
                >
                    <i className="fa fa-search"/>
                </Button>
            </InputGroup.Button>
            <InputGroup.Button>
                <Button
                    bsStyle="warning"
                    disabled={ search === '' }
                    onClick={ () => {
                        if ( search !== '' ) {
                            handleClearSearch();
                        }
                    } }
                    title="Clear search"
                    type="button"
                >
                    <i className="fa fa-eraser"/>
                </Button>
            </InputGroup.Button>
        </span>
    )
}

SearchGroup.propTypes = {
    handleClearSearch      : PropTypes.func.isRequired,
    handleClickSearch      : PropTypes.func.isRequired,
    handleSearchInputChange: PropTypes.func.isRequired,
    search                 : PropTypes.string.isRequired,
    searchInput            : PropTypes.string.isRequired,
    searchPlaceholder      : PropTypes.string.isRequired
};