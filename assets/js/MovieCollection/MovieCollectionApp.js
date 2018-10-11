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

        this.state = {
            collection: []
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

MovieCollectionApp.propTypes = {};



