/**
 * user-menu.jsx: redux store for general page settings.
 *
 * Note: this script implements jsx (reactjs) syntax.
 *
 * Note: importing 'named export' (multiple export statements in a module),
 *       requires the object being imported, to be surrounded by { brackets }.
 *
 */

import React from 'react';
import { connect } from 'react-redux';
import UserMenu from '../../navigation/user-menu.jsx';

// transforms redux state tree to react properties
const mapStateToProps = (state) => {
  // return redux to state
    return {
        layout: {
            type: state.layout
        }
    }
}

// pass selected properties from redux state tree to component
const UserMenuState = connect(
    mapStateToProps,
    null
)(UserMenu)

// indicate which class can be exported, and instantiated via 'require'
export default UserMenuState