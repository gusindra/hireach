var buttons = document.querySelectorAll("[data-target='tooltip_trigger']");
buttons.forEach((button)=>{
    var tooltip = button.nextElementSibling;
    var placement = tooltip.getAttribute("data-popper-placement");
    const popperInstance = Popper.createPopper(button, tooltip, {
        modifiers: [{
            name: "offset",
            options: {
                offset: [0, 8],
            },
        }, ],
        placement: placement,
    });
    function show() {
        tooltip.classList.remove("hidden");
        tooltip.classList.add("block");
        popperInstance.setOptions((options)=>({
            ...options,
            modifiers: [...options.modifiers, {
                name: "eventListeners",
                enabled: true
            }],
        }));
        popperInstance.update();
    }
    function hide() {
        tooltip.classList.add("hidden");
        tooltip.classList.remove("block");
        popperInstance.setOptions((options)=>({
            ...options,
            modifiers: [...options.modifiers, {
                name: "eventListeners",
                enabled: false
            }],
        }));
    }
    const showEvents = ["mouseenter", "focus"];
    const hideEvents = ["mouseleave", "blur"];
    showEvents.forEach((event)=>{
        button.addEventListener(event, show);
    }
    );
    hideEvents.forEach((event)=>{
        button.addEventListener(event, hide);
    }
    );
}
);
