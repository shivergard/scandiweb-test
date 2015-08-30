import React from 'react';

class Description extends React.Component {

    /**
     * Render component
     */
    render() {

        return <td className="description">{this.props.description}</td>
    }
}

module.exports = Description;