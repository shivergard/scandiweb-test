import React from 'react';
import _ from 'lodash';
import classNames from 'classnames';

class Paginator extends React.Component {

    /**
     * Props validation
     *
     * @type {Object}
     */
    static propTypes = {
        currPage: React.PropTypes.number.isRequired,
        lastPage: React.PropTypes.number.isRequired,
        onChange: React.PropTypes.func.isRequired
    };

    /**
     * Previous page clicked
     */
    prevPageClicked() {
        if (this.props.currPage > 1) this.props.onChange(Number(this.props.currPage) - 1);
    }

    /**
     * Next page clicked
     */
    nextPageClicked() {
        if (this.props.currPage < this.props.lastPage) this.props.onChange(Number(this.props.currPage) + 1);
    }

    /**
     * Page clicked
     *
     * @param {Number} pageNum
     */
    pageClicked(pageNum) {
        if (this.props.currPage != pageNum) this.props.onChange(Number(pageNum));
    }

    /**
     * Render previous
     *
     * @returns {XML}
     */
    renderPrevious() {
        var classStr = classNames({disabled: this.props.currPage <= 1});

        return <li key="prev" className={classStr}>
            <a rel="prev" onClick={this.prevPageClicked.bind(this)}>«</a>
        </li>
    }

    /**
     * Render next
     *
     * @returns {XML}
     */
    renderNext() {
        var classStr = classNames({disabled: this.props.currPage >= this.props.lastPage});

        return <li key="next" className={classStr}>
            <a rel="next" onClick={this.nextPageClicked.bind(this)}>»</a>
        </li>
    }

    /**
     * Render dots
     *
     * @param {String} key
     * @returns {XML}
     */
    renderDots(key) {

        return <li key={key} className="disabled"><span>...</span></li>;
    }

    /**
     * Render number
     *
     * @param {Number} num
     * @returns {XML}
     */
    renderNumber(num) {
        var classStr = classNames({active: this.props.currPage == num});

        return <li key={num} className={classStr}>
            <a onClick={_.partial(this.pageClicked.bind(this), num)}>{num}</a>
        </li>
    }

    /**
     * Render range
     *
     * @param {Number} firstNum
     * @param {Number} lastNum
     * @returns {Array}
     */
    renderRange(firstNum, lastNum) {
        var pages = [];

        for (var i = firstNum; i <= lastNum; i++) {
            pages.push(this.renderNumber(i));
        }

        return pages;
    }

    /**
     * Render start
     *
     * @returns {Array}
     */
    renderStart() {
        var pages = this.renderRange(1, 2);

        pages.push(this.renderDots('dots-start'));

        return pages;
    }

    /**
     * Render finish
     *
     * @returns {Array}
     */
    renderFinish() {
        var pages = this.renderRange(this.props.lastPage - 1, this.props.lastPage);

        pages.unshift(this.renderDots('dots-finish'));

        return pages;
    }

    /**
     * Render adjacent range
     *
     * @returns {Array}
     */
    renderAdjacentRange() {

        return this.renderRange(this.props.currPage - 2, this.props.currPage + 2);
    }

    /**
     * Render slider
     *
     * @returns {Array}
     */
    renderSlider() {
        var sliderNum = 6;
        var buttons = [];

        if (this.props.currPage <= sliderNum) {
            buttons = buttons.concat(this.renderRange(1, sliderNum + 2));
            buttons = buttons.concat(this.renderFinish());
        }

        else if (this.props.currPage >= this.props.lastPage - sliderNum) {
            buttons = buttons.concat(this.renderStart());
            buttons = buttons.concat(this.renderRange(this.props.lastPage - sliderNum, this.props.lastPage));
        }

        else {
            buttons = buttons.concat(this.renderStart());
            buttons = buttons.concat(this.renderAdjacentRange());
            buttons = buttons.concat(this.renderFinish());
        }

        return buttons;
    }

    /**
     * Render component
     *
     * @returns {XML}
     */
    render() {
        // hide paginator if only one page
        if (
            this.props.to === this.props.total
            && this.props.currPage === 1
        ) {

            return <div></div>;
        }

        var buttons = [];

        buttons.push(this.renderPrevious());

        if (this.props.lastPage <= 13) {
            buttons = buttons.concat(this.renderRange(1, this.props.lastPage));
        }
        else {
            buttons = buttons.concat(this.renderSlider());
        }

        buttons.push(this.renderNext());

        return <div className="pagination">
            <ul>{buttons}</ul>
        </div>
    }
}

module.exports = Paginator;
