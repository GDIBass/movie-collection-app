import React, { Component } from 'react';
import PropTypes            from 'prop-types';
import {
    Button,
    FormControl,
    InputGroup,
    Panel
}                           from 'react-bootstrap';
import Result               from "./Result";

export default class Search extends Component {
    constructor(props) {
        super(props);

        const { search } = props;

        this.state = {
            searchInput: search
        };

        this.handleSearchInputChange = this.handleSearchInputChange.bind(this);
    }

    handleSearchInputChange(event) {
        this.setState({
            searchInput: event.target.value
        });
    }

    render() {

        const { search, searchResults } = this.props;

        const results = searchResults ? searchResults.results : [];
        const total   = searchResults ?
                        searchResults.total_results + ' Total Results' :
                        'No Results';

        return (
            <div id="search">
                <h2>Search All Movies</h2>
                <Panel>
                    <Panel.Heading>
                        <InputGroup>
                            <input
                                className="form-control"
                                onChange={ this.handleSearchInputChange }
                                placeholder="Search For Movies"
                                type="text"
                            />
                            <InputGroup.Button>
                                <Button
                                    bsStyle="info"
                                    disabled={ search === this.state.searchInput }
                                    title="Go!"
                                    type="button"
                                >
                                    <i className="fa fa-search"/>
                                </Button>
                            </InputGroup.Button>
                            <InputGroup.Button>
                                <Button
                                    bsStyle="warning"
                                    disabled={ search === null }
                                    title="Clear search"
                                    type="button"
                                >
                                    <i className="fa fa-eraser"/>
                                </Button>
                            </InputGroup.Button>
                        </InputGroup>
                    </Panel.Heading>
                    <Panel.Body className="moviedb-search">
                        {
                            results.map((item, key) =>
                                <Result
                                    key={ key }
                                    result={ item }
                                />
                            )
                        }
                        <div>
                            { total }
                        </div>
                    </Panel.Body>
                </Panel>
            </div>
        );
    }
}

Search.propTypes = {
    search       : PropTypes.string,
    searcHResults: PropTypes.object
};
