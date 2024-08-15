particlesJS('particles-js', {
  "particles": {
    "number": {
      "value": 200,
      "density": {
        "enable": true,
        "value_area": 1000
      }
    },
    "color": {
      "value": "#FF6F6F" 
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#FF6F6F"
      }
    },
    "opacity": {
      "value": 1,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value":2.5,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.025,
        "sync": false
      }
    },
    "line_linked": {
      "enable": false
    },
"move": {
  "enable": true,
  "speed": 3.5,
  "direction": "none",
  "random": true,
  "straight": false,
  "out_mode": "bounce",
  "bounce": false,
  "attract": {
    "enable": false,
    "rotateX": 600,
    "rotateY": 1200
  },
  "repulse": {
    "enable": true, // Enable repulsion
    "distance": 500, // Distance between particles to start repelling
    "duration": 0.4 // Duration of the repulsion animation
  },
  "random_speed_anim": {
    "enable": true,
    "speed_min": 1,
    "speed_max": 10,
    "speed_step": 0.1
  },
  "random_move_direction_anim": {
    "enable": true,
    "speed": 180
  }
}

  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": true,
        "mode": "repulse",
        "el": ".loginBoxContainer" // Exclude the login box container from interactions
      },
      "onclick": {
        "enable": true,
        "mode": "push",
        "el": ".loginBoxContainer" // Exclude the login box container from interactions
      },
      "resize": true
    },
    "modes": {
      "repulse": {
        "distance": 100, // Increased repulsion distance
        "duration": 20 // Increased duration of the repulsion effect
      },
      "push": {
        "particles_nb": 10
      }
    }
  },
  "retina_detect": true,
  "fn": {
    // Custom function to calculate the particle area
    "area_calc": function(p, canvas_el) {
      // Get the dimensions and position of the login box
      const loginBox = document.querySelector('.lbox');
      const loginBoxRect = loginBox.getBoundingClientRect();
      // Calculate the area outside the login box
      const canvasRect = canvas_el.getBoundingClientRect();
      const areaLeft = canvasRect.left;
      const areaRight = canvasRect.right;
      const areaTop = canvasRect.top;
      const areaBottom = loginBoxRect.top;
      const areaHeight = areaBottom - areaTop;
      const areaWidth = areaRight - areaLeft;
      // Subtract the area occupied by the login box
      const loginBoxWidth = loginBoxRect.right - loginBoxRect.left;
      const loginBoxHeight = loginBoxRect.bottom - loginBoxRect.top;
      const loginBoxArea = loginBoxWidth * loginBoxHeight;
      return areaWidth * areaHeight - loginBoxArea;
    }
  }
});