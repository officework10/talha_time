(function ( $ ){

var PREFIX = "fraction_painter_";
var NEW_HEIGHT = 100;
var WIDTH_HEIGHT_SCALE = 0.98;

function Fraction (numerator, denominator, integerPart) {
    this.numerator = numerator;
    this.denominator = denominator;
    this.integerPart = integerPart !== undefined ? integerPart:0;
    
    this.calculateIntegerPart = function(){
        this.integerPart += parseInt(this.numerator/this.denominator);
        this.numerator = this.numerator % this.denominator;
    }
}

function Rectangle (x, y, width, height) {
    this.x = x;
    this.y = y;
    this.width = width;
    this.height = height;
}

function FractionPainter() {
    this.uuid = new Date().getTime();

    this._default_values = { width: 400, height: 300, numerator: 1, denominator: 2};

    this.get = function(instance, options) {
        return instance.settings[options] !== undefined? instance.settings[options]: this._default_values[options];
    };

    this.createCanvas = function(instance){
        var width = $.fractionPainter.get(instance, "width")+'%';
        var height = $.fractionPainter.get(instance, "height")+'%';
        var canvasId = "canvas_" + instance.id;
        
        var canvas = $("<canvas/>")
            .attr("width", width)
            .attr("height", height)
            .attr("id", canvasId);
        
        return canvas;
    };
    
    this.paintFraction = function(instance, ctx) {
        var ar = $.fractionPainter.get(instance, "width") / $.fractionPainter.get(instance, "height");
        
        var _width = ar * NEW_HEIGHT;
        
        var fraction = new Fraction($.fractionPainter.get(instance, "numerator"), $.fractionPainter.get(instance, "denominator"));
        
        fraction.calculateIntegerPart();
        
        var deltaWidth = _width / (fraction.integerPart + (fraction.numerator > 0? 1:0));
        var x = (- NEW_HEIGHT * ar + deltaWidth) / 2;
       
        var rect = new Rectangle(x, 0, deltaWidth, NEW_HEIGHT);
        
        this._paintIntegerPart(instance, ctx, fraction, rect);

        if(fraction.numerator != 0) {
            this._painFractionPart(instance, ctx, fraction, rect);
        }
    }
    
    this._painFractionPart = function(instance, ctx, fraction, rect) {
        ctx.translate(rect.x + fraction.integerPart * rect.width, rect.y);
        
        this._paintPie(instance, ctx, fraction.numerator, fraction.denominator,
            rect.width * WIDTH_HEIGHT_SCALE, rect.height * WIDTH_HEIGHT_SCALE);
    }
    
    this._paintIntegerPart = function(instance, ctx, fraction, rect) {
        for(var k = 0; k < fraction.integerPart; k++) {
            ctx.save();
            ctx.translate(rect.x + k * rect.width, rect.y);
            
            this._paintPie(instance, ctx, fraction.denominator, fraction.denominator, 
                rect.width * WIDTH_HEIGHT_SCALE, rect.height * WIDTH_HEIGHT_SCALE);
            ctx.restore();
        }
    }

    this._paintPie = function(instance, context, numerator, denominator, width, height) {
        var _ctx = context;

        var _fillColor = "#1e5b80";
        var _fillInactiveColor = "#ececec";
        var _strokeColor = "#333333";

        var angle = 2 * Math.PI / denominator;
        var radius = Math.min(width, height)/2;

        _ctx.fillStyle = _fillColor;
        _ctx.lineWidth = 0.47;
        _ctx.beginPath();
        _ctx.arc(0, 0, radius, 0, numerator * angle);
        _ctx.lineTo(0,0);
        _ctx.fill();
        
        _ctx.fillStyle = _fillInactiveColor;
        _ctx.beginPath();
        _ctx.arc(0, 0, radius, numerator * angle, denominator * angle);
        _ctx.lineTo(0,0);
        _ctx.fill();
        
        _ctx.strokeStyle= _strokeColor;
        
        for(var k = 0; k < denominator; k++) {
            _ctx.beginPath();
            _ctx.arc(0, 0, radius, k * angle, (k + 1) * angle);
            _ctx.lineTo(0,0);
            
            _ctx.stroke();
        }
    };

    this.setMatrix = function(instance, ctx) {
        var width = $.fractionPainter.get(instance, "width");
		var height = $.fractionPainter.get(instance, "height");
        var newWidth = NEW_HEIGHT * width/height;
        
        ctx.setTransform(width/newWidth, 0, 0, -height/NEW_HEIGHT, width/2, height/2);
    }
}

$.fractionPainter = new FractionPainter();

$.fn.fractionPainter = function(options) {	
    return this.each( function() {
        if ( this.id === undefined || this.id === "") {
            this.id = PREFIX + $.fractionPainter.uuid;
            $.fractionPainter.uuid++;
        }
        
        var instance = {
            id: this.id,
            settings: $.extend(options, {})
        };
        canvas = $.fractionPainter.createCanvas(instance);
        
        $(this).html(canvas);

        ctx = canvas[0].getContext("2d");
        $.fractionPainter.setMatrix(instance, ctx);
        $.fractionPainter.paintFraction(instance, ctx);
        });
    };
}( jQuery ));
