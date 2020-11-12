var i = 0;
var j = 0;
var subheadingStrings = [       // list of strings displayed at the subheading
    'Programming the World Wide Web by Robert W. Sebesta', 
    'Sultana\'s Dream by Begum Rokeya', 
    'Data Interpretation & Logical Reasoning by R.S. Agarwal', 
    'Sherlock Holmes by Arthur Conan Doyle'
];
var speed = 150;
var increment = true        // to keep counter of when to increment and decrement in typewrite animation

// typewriter effect on the subheading
// keep increasing i value till all the letters in that string has been printed and then start decresing i value
// i comes back to 0; we increment j to go to the next string in the array
function typeWrite() {
    if (i <= subheadingStrings[j].length && increment == true) {
        document.getElementById("description").innerHTML = subheadingStrings[j].slice(0, i);
        i++;
        setTimeout(typeWrite, speed);
    } else if (i > subheadingStrings[j].length) {
        // we have a css attribute which gives us the blink animation. So whenever string reaches its end we add the animation to the cursor
        document.getElementById("cursor").id = "cursor-animation";
        i--;
        increment = false
        setTimeout(function() {
            // removing the blink animation css attribute when we have to start decrementing i
            document.getElementById("cursor-animation").id = "cursor";
            typeWrite()
        }, 3000);
    } else if (i < 0) {
        i++;
        j = (++j)%(subheadingStrings.length)     // make sure we stay in the four strings in the array
        increment = true
        typeWrite()
    } else if(i >= 0 && increment == false) {
        document.getElementById("description").innerHTML = subheadingStrings[j].slice(0, i);
        i--;
        setTimeout(typeWrite, speed);
    }
}