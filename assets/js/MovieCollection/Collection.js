import React, { Component } from 'react';
import PropTypes            from 'prop-types';
import {
    Button,
    FormGroup,
    InputGroup,
    Panel
}                           from 'react-bootstrap';
import CollectionItem       from "./CollectionItem";

export default class Collection extends Component {
    constructor(props) {
        super(props);

        this.state = {
            collectionSearch     : '',
            collectionSearchInput: ''
        };

        this.handleSearchInputChange = this.handleSearchInputChange.bind(this);
    }

    handleSearchInputChange(event) {
        this.setState({
            collectionSearchInput: event.target.value
        });
    }

    render() {

        const { collection } = this.props;

        return (
            <div id="my-collection">
                <h2>My Collection</h2>
                <Panel>
                    <Panel.Heading>
                        <FormGroup className="mb-0">
                            <InputGroup>
                                <input
                                    className="form-control"
                                    onChange={ this.handleSearchInputChange }
                                    placeholder="Search My Collection"
                                    type="text"
                                />
                                <InputGroup.Button>
                                    <Button
                                        bsStyle="info"
                                        title="Go!"
                                        type="button"
                                    >
                                        <i className="fa fa-search"/>
                                    </Button>
                                </InputGroup.Button>
                                <InputGroup.Button>
                                    <Button
                                        bsStyle="warning"
                                        title="Clear Search"
                                        type="button"
                                    >
                                        <i className="fa fa-eraser"/>
                                    </Button>
                                </InputGroup.Button>
                            </InputGroup>
                        </FormGroup>
                    </Panel.Heading>
                    <Panel.Body className="my-collection">
                        {
                            collection.map((collectionItem, key) =>
                                <CollectionItem
                                    collectionItem={ collectionItem }
                                    key={ key }
                                />
                            )
                        }
                        <div className="right-box">'</div>
                    </Panel.Body>
                </Panel>
            </div>
        );
    }
}

Collection.propTypes = {
    collection      : PropTypes.array.isRequired
};
