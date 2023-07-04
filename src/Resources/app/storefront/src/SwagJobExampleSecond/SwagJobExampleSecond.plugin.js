import Plugin from 'src/plugin-system/plugin.class';

export default class SwagJobExampleSecond extends Plugin {
        init() {
            console.log("init invoked");
        window.addEventListener('scroll', this.onScroll.bind(this));
    }

    onScroll() {
        console.log("Show Alert", ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) );
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            alert('Seems like there\'s nothing more to see here.');
        }
    }
}