/*
** under kikou license (or MIT if you don't know it)
*/
(function($) {
    // a class to manage the slider.
    var cSlider = function(item, options) {

        // The object on which circularslider is
        // called
        var element = null;
        // DOM element that represents the
        // moving part of the circular slider
        var slider = null;
        // The clone is what you really move when
        // you slide. Its positions allows to calculate
        // the slider position. (it's invisible, btw)
        var clone;

        var settings = {
            // current value of the slider
            value: 0,
            // minimal value of the slider
            min: 0,
            // maximal value of the slider
            max: 360,
            // The step is... the step. You know
            // what it is.
            // Every value between 0 and 10 with a
            // step of 1 are:
            // {0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10}
            // with a step of 2 they are:
            // {0, 2, 4, 6, 8, 10}
            // with a step of 3:
            // {0, 3, 6, 9}
            // If you still don't get it, go back to school.
            step: 1,
            // If clockwise is set to true, then turning the slider
            // on the clockwise direction will increase the value
            clockwise: false,
            // zeroPos is the position where the slider value is 0
            // possible values for zeroPos are:
            // - 'left'
            // - 'top'
            // - 'right'
            // - 'bottom'
            zeroPos: 'left',
            // EVENTS
            // If defined, this function will be called everytime
            // the value changes. The first argument will be the
            // currect value
            giveMeTheValuePlease: false
        };
        
        // In order to allow negative values and values not
        // starting at 0, this is a cool information to have
        var minmaxdif;

        // To keep the instance of the object everywhere (and
        // usable in callbacks.
        // I don't think I need it in this class but I believe
        // it's a good practice (or at least an often-practical
        // practice).
        var that = this;
        // Magic val is (minmaxdif / 2*PI) which is a
        // value that is needed everytime the value
        // of the slider changes but its a constant
        // so there is no need to do the operation
        // every time.
        var magicval = 0;
        // Another value that I use often and it annoys me
        // to calculate every time
        var twopi = Math.PI * 2;
        // This is a value that I will use to trick the zero Position
        var zeroAngle = 0;
        
        // basic data needed to do the 
        var data = {
            center: {
                x: 0,  // absolute position in the page
                y: 0
            }, // of the center of the slider
            a: 0, // horizontal radius
            b: 0, // vertical radius
            isCircle: false
        };
        
        // This code was made to support any eliptic form,
        // that's why there is data.a and data.b which
        // represent the small and the big radiuses of
        // an elipse.
        // Since it's 6 in the morning, I will just manage
        // simple circles, but if some other morning I have
        // nothing interesting to do, I'll make it support
        // elipses. (who cares about them anyway?)
        var setData = function() {
            var offset = slider.offset();
            data.a = (element.width() / 2);
            data.b = (element.height() / 2);
            data.center.x = offset.left + data.a;
            data.center.y = offset.top + data.b;

            // That's for when the plugin will manage
            // elipses (some day or never). If in the
            // initialization we found it's a circle
            // we will be able to optimize the operations
            // (because in real life, everybody hates elipses)
            if (data.a == data.b) {
                data.isCircle = true;
            }
        }

        var recenter = function() {
            var offset = element.offset();
            data.center.x = offset.left + data.a;
            data.center.y = offset.top + data.b;
        }
        
        // This method is called at the construction of the
        // object. It processes the options and initializes
        // some stuff.
        var init = function(item, options) {
            $.extend(settings, options);

            minmaxdif =  Math.abs(settings.max - settings.min);

            element = item;

            element.css({
                position: 'relative'
            });

            // the cute slider that moves around like a fish
            // in a tank.
            slider = $('<div></div>').css({
                position: 'absolute',
                top: 0,
                left: 0
            }).addClass('ui-circular-slider').draggable({
                //containment: 'parent',
                drag: move,
                helper: function() {
                    return clone;
                }
            });
            element.append(slider);

            // this will be the helper sent given to the draggable plugin
            clone = $('<div></div>');

            setData();

            magicval = minmaxdif / twopi;
            
            switch(settings.zeroPos) {
                case 'left':
                    zeroAngle = Math.PI;
                    break;
                case 'right':
                    zeroAngle = 0;
                    break;
                case 'top': 
                    zeroAngle = Math.PI / 2;
                    break;
                case 'bottom':
                    zeroAngle = 3*Math.PI / 2;
                    break;
            }

            refresh();
        }

        // Allows to set the value of the slider.
        // If the value is out of bounds, it will
        // be ignored.
        // If the value is greater than the minimum
        // and lower than the maximum, it will be
        // converted in order to match one of the
        // steps of the slider.
        var set = function(val) {
            if (val < settings.min || val > settings.max) {
                return;
            }

            settings.value = Math.round( val / settings.step) * settings.step;

            if (settings.giveMeTheValuePlease) {
                settings.giveMeTheValuePlease(settings.value);
            }

            refresh();
        }
        
        var move = function(event, ui) {
            var angle = Math.atan2(data.center.y - event.pageY, event.pageX - data.center.x);
           
            var v = 0;
            if (angle < 0) {
                angle = twopi + (angle  % twopi);
            }

            angle = (angle - zeroAngle) % twopi;
            if (angle < 0) 
                angle = twopi + angle;
            

            if (settings.clockwise)
                v = (twopi - angle) * magicval;
            else
                v = angle * magicval;

            set(v);
        }

        var refresh = function() {
            recenter();
            var angle = 0;
            if (settings.clockwise) {
                angle = twopi - ( (settings.value) / magicval);
            } else {
                angle = ((settings.value) / magicval);
            }

            angle = (angle + zeroAngle) % twopi; // % twopi;
            if (angle < 0) {
                angle = twopi + angle;
            }

            slider.css({
                left: (data.a + data.a * Math.cos(angle)) + 'px',
                top: (data.b - data.b * Math.sin(angle)) + 'px'
            });
        }
        
        var get = function() {
            return (settings.min + settings.value);
        }
        
        init(item, options);

        return {
            get:get,
            set:set
        };
    }
    
    // The options are detailed above. See the settings attributes
    // in the cSlider class.
    // giveMeTheAPI, if defined, is a funciton that will be called once
    // the slider is initialized. The first argument if an object 
    // that has a very simple API to control the slider from outside.
    // The methods available to the API are:
    // - set(val) which will set the slider value to val (or the closest
    //   possible value depending on the allowed values of the slider
    //   defined in the options).
    // - get() which returns the current value
    $.fn.circularslider = function(options, giveMeTheAPI) {
        this.each(function() {
            var slider = new cSlider($(this), options);

            if (typeof giveMeTheAPI == 'function') {
                giveMeTheAPI(slider);
            }
        });
        return this;
    };
})(jQuery);