import React from 'react';

class Date extends React.Component {

    /**
     * Render component
     */
    render() {

        return <td className="date">{this.props.timestamp}</td>
    }
}

module.exports = Date;