import React from 'react';
import toastr from 'toastr';
import TimeParser from '../lib/timeparser.js'

class Form extends React.Component {

    /**
     * Component state
     *
     * @type {object}
     */
    state = {
        descriptionValue: '',
        timeSpentValue: ''
    };

    /**
     * Handle submit event
     */
    handleSubmit(e) {
        e.preventDefault();

        var description = this.state.descriptionValue;
        var time_spent = new TimeParser().parse(this.state.timeSpentValue);

        // there could be some validation service
        // implementing such feature is quite time consuming
        // and because this is just a test, I decided to skip this feature
        if (description && time_spent !== 0) {
            this.props.submitEvent({description, time_spent});

            this.setState({
                descriptionValue: '',
                timeSpentValue: ''
            });
        } else {
            toastr.error('Form data is not valid!');
        }
    }

    /**
     * Update description
     *
     * @param {object} e
     */
    updateDescription(e) {
        this.setState({
            descriptionValue: e.target.value
        });
    }

    /**
     * Update time spent
     *
     * @param {object} e
     */
    updateTimeSpent(e) {
        this.setState({
            timeSpentValue: e.target.value
        });
    }
    /**
     * Render component
     */
    render() {

        return <form
            className="add-task"
            onSubmit={this.handleSubmit.bind(this)}
            >
            <input
                ref="description"
                value={this.state.descriptionValue}
                onChange={this.updateDescription.bind(this)}
                placeholder="Description"
                />
            <input
                ref="time-spent"
                value={this.state.timeSpentValue}
                onChange={this.updateTimeSpent.bind(this)}
                placeholder="Time spent"
                />
            <input className="button" type="submit" value="Add" />
        </form>
    }
}

module.exports = Form;