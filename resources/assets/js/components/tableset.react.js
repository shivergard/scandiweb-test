import React from 'react';
import Moment from 'moment';
import _ from 'lodash';
import Table from './table.react.js';

class TableSet extends React.Component {

    /**
     * Table set state
     *
     * @type {Object}
     */
    state = {
        groupedTasks: {}
    };

    /**
     * Functions on table set initialization
     */
    componentWillMount() {
        this.groupTables();
    }

    /**
     * Functions on component update
     *
     * @param {Object} nextProps
     */
    componentWillReceiveProps(nextProps) {
        this.groupTables(nextProps);
    }

    /**
     * Set grouped tables
     *
     * @param {Object} nextProp
     */
    groupTables(nextProp = null) {
        var data = nextProp ? nextProp.data : this.props.data;

        var groupedTasks = _.groupBy(data, (task) => {

            return this.timestampToDate(task.created_at);
        });

        this.setState({
            groupedTasks: groupedTasks
        });
    }

    /**
     * Converts timestamp to date
     *
     * @param {String} timeStamp
     * @returns {String}
     */
    timestampToDate(timeStamp) {

        return Moment(timeStamp).format('DD.MM.YYYY');
    }

    /**
     * Formats date for heading
     *
     * @param {String} date
     * @returns {String}
     */
    formatDate(date) {

        return Moment(date).isSame(Moment(), 'day') ? 'Today' : this.timestampToDate(date);
    }

    /**
     * Render component
     */
    render() {

        var tableSet = [];
        _.forEach(this.state.groupedTasks, (tasks, date) => {

            // using timestamp instead of key because of moment.js issue
            // https://github.com/moment/moment/issues/1407
            var dateStamp = tasks[0].created_at;

            tableSet.push(<div key={date}>
                <h2>{this.formatDate(dateStamp)}</h2>
                <Table data={tasks}/>
            </div>);
        });

        return <div>{tableSet}</div>;
    }
}

module.exports = TableSet;