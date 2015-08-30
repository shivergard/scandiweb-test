import React from 'react';
import HumanizeDuration from 'humanize-duration';

class TimeSpent extends React.Component {

    /**
     * Configure Humanize duration lib
     */
    configureHumanizeLib() {

        return HumanizeDuration.humanizer({
            language: "shortEn",
            languages: {
                shortEn: {
                    y: function() { return "y"; },
                    mo: function() { return "mo"; },
                    w: function() { return "w"; },
                    d: function() { return "d"; },
                    h: function() { return "h"; },
                    m: function() { return "m"; },
                    s: function() { return "s"; },
                    ms: function() { return "ms"; }
                }
            }
        });
    }

    /**
     * Render component
     */
    render() {
        var milliseconds = this.props.minutes * 1000 * 60,
            shortEnglishHumanizer = this.configureHumanizeLib();

        return <td className="time-spent">{shortEnglishHumanizer(milliseconds)}</td>
    }
}

module.exports = TimeSpent;