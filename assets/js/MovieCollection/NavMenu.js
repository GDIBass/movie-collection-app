import React     from 'react';
import PropTypes from 'prop-types';
import {
    MenuItem, Nav, Navbar, NavDropdown, NavItem
}                from 'react-bootstrap';

export default function NavMenu({}) {
    return (
        <nav>
            <Navbar fixedTop>
                <Navbar.Header>
                    <Navbar.Brand>
                        Movie Collection
                    </Navbar.Brand>
                </Navbar.Header>
                <Navbar.Collapse>
                    <Nav>
                        <NavItem href="#search">
                            Search
                        </NavItem>
                        <NavItem href="#my-collection">
                            My Collection
                        </NavItem>
                    </Nav>
                    <Nav pullRight>
                        <NavDropdown title="Neo">
                            <MenuItem>Profile</MenuItem>
                            <MenuItem>Settings</MenuItem>
                            <MenuItem>Log Out</MenuItem>
                        </NavDropdown>
                    </Nav>
                </Navbar.Collapse>
            </Navbar>
        </nav>
    );
}

NavMenu.propTypes = {};