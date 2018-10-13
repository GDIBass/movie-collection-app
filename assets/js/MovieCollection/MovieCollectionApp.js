import React, { Component } from 'react';
import PropTypes            from 'prop-types';
import Collection           from "./Collection";
import {
    Grid, Row
}                           from 'react-bootstrap';
import Search               from "./Search";
import NavMenu              from "./NavMenu";

export default class MovieCollectionApp extends Component {
    constructor(props) {
        super(props);

        const { collection } = props;

        this.state = {
            collection      : collection,
            search          : '',
            searchResults   : null
        };
    }

    render() {
        return (
            <div>
                <NavMenu/>
                <main>
                    <Grid>
                        <Row>
                            <Search
                                search={ this.state.search }
                                searchResults={ this.state.searchResults }
                            />
                        </Row>
                        <Row>
                            <Collection
                                collection={ this.state.collection }
                            />
                        </Row>
                    </Grid>
                </main>
            </div>
        );
    }
}

MovieCollectionApp
    .propTypes = {
    collection: PropTypes.array.isRequired
};


