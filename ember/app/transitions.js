export default function(){
	this.transition(
		this.fromRoute('group.index'),
		this.toRoute('skill.index'),
		this.use('explode', {
			matchBy: 'data-skill-id',
			use: 'fly-to'
			// use: ['fly-to', {duration, easing: 'spring'}]
		})
	);
}
