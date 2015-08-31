import React from 'react';
import $ from 'jquery';
import toastr from 'toastr';
import _ from 'lodash';
import Paginator from './components/paginator.react.js';
import TableSet from './components/tableset.react.js';
import Form from './components/form.react.js';

class TimeLog extends React.Component {

    /**
     * Time log state
     *
     * @type {object}
     */
    state = {
        tasks: {
            current_page: 1,
            data: [],
            from: null,
            last_page: 1,
            next_page_url: null,
            per_page: null,
            prev_page_url: null,
            to: null,
            total: 0
        }
    };

    /**
     * Get tasks
     *
     * @param page
     */
    getTasks(page = 1) {
        $.get('/tasks?page=' + page, function (data) {
            this.setState({tasks: data});
        }.bind(this));
    }

    /**
     * Functions on app initialization
     */
    componentDidMount() {
        this.getTasks();
    }

    /**
     * Checks if app has has has data
     *
     * @returns {Number}
     */
    hasData() {

        return this.state.tasks.data.length;
    }

    /**
     * Post post form
     *
     * @param {Object} postedData
     */
    postForm(postedData) {
        $.ajax({
            context: this,
            type: "POST",
            url: '/tasks',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: postedData,
            dataType: 'json',
            success: function (newEntry) {

                // dear reviewer table is updated not right away, but on ajax response
                // reason is that timestamp will not be correct on slow connections/servers
                // on page refresh it will change by 1-2 seconds
                this.updateTable(newEntry);

                toastr.info('Task saved!');
            },
            error: function () {
                toastr.error('Could not save task!');
            }
        });

    }

    /**
     * Update table after submit
     *
     * @param {object} newEntry
     */
    updateTable(newEntry) {
        if (this.state.tasks.current_page === 1) {

            // modify data array
            var oldData = this.state.tasks.data;
            oldData.unshift(newEntry);

            // keep state, only update part of object
            var tasks = _.assign({}, this.state.tasks);

            if (this.state.tasks.total >= this.state.tasks.per_page) {
                oldData.pop();
            }

            if (this.state.tasks.total < this.state.tasks.per_page) {
                tasks.to = this.state.tasks.to + 1;
            }

            if(this.state.tasks.total == this.state.tasks.per_page - 1) {
                tasks.last_page = this.state.tasks.last_page + 1;
            }

            tasks.data = oldData;
            tasks.total = this.state.tasks.total + 1;

            this.setState({tasks: tasks});
        } else {
            this.getTasks(this.state.tasks.current_page);
        }
    }

    /**
     * Render component
     */
    render() {
        var data = [];
        if (this.hasData()) {
            data = <div>
                <TableSet data={this.state.tasks.data}/>
                <Paginator
                    to={this.state.tasks.to}
                    total={this.state.tasks.total}
                    currPage={this.state.tasks.current_page}
                    lastPage={this.state.tasks.last_page}
                    onChange={this.getTasks.bind(this)}
                    />
            </div>;
        }

        return <div>
            <div className="results">
                {data}
            </div>
            <div className="form">
                <Form submitEvent={this.postForm.bind(this)}/>
            </div>
        </div>
    }
}

React.render(<TimeLog/>, document.getElementById('app'));