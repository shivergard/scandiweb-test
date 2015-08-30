import React from 'react';
import Moment from 'moment';
import TimeSpent from './time_spent_row.react.js';
import Description from './decription_row.react.js';
import Date from './date_row.react.js';

class Table extends React.Component {

    /**
     * Render component
     */
    render() {
        var taskRows = this.props.data.map((task) => {

            return <tr key={task.id}>
                <Description description={task.description}/>
                <TimeSpent minutes={task.time_spent}/>
                <Date timestamp={task.created_at} />
            </tr>
        });

        return <div>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Time spent</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {taskRows}
                </tbody>
            </table>
        </div>
    }
}

module.exports = Table;