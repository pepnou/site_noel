class Planet
{
	constructor(x, y, name, date)
	{
		this.r = Math.sqrt(x*x+y*y);
		this.theta = Math.atan(x/y);
		this.name = name;
		this.date = date;
		this.hit = false;
	}

	update()
	{
		var centerMass = 2*Math.pow(10,15);
		var speed = Math.sqrt(6.674*Math.pow(10,-11)*centerMass/this.r);
		var perimeter = 2*Math.PI*this.r;

		this.theta += speed/perimeter*2*Math.PI;
	}

	getX()
	{
		return Math.cos(this.theta)*this.r;
	}

	getY()
	{
		return Math.sin(this.theta)*this.r;
	}


}