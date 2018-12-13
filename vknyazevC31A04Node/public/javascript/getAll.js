class TaskLoader {
    constructor(cb) {
        this.cb = cb;
    }

    start() {
        this.loader = setInterval(() => {
            fetch("/list/" + this.type, {method: "POST"}).then(d => d.json()).then(this.cb)
        }, 1000)
    }

    stop() {
        clearInterval(this.loader);
    }
}

function generateTaskHtml(task) {
    let box = document.createElement("div");
    box.classList.add("col-md-6", "col-sm-12")
    box.innerHTML = `
    <div class="jumbotron">
                    <h2>
                        ${statusToBadge(task.status)} ${task.title}</h2>
                    <table class="table table-striped table-bordered">
                                                <tr>
                            <th>Updated On</th>
                            <td>
                                ${new Date(task.dateUpdated*1000).toString()}                            </td>
                        </tr>
                    </table>

                    <a href="/task/${task.id}" class="btn btn-primary">Open</a>
                </div>
    `
    return box;
}


function statusToBadge(status)
{
    let text = "Uknown Status";
    let className = "dark";
    switch (status) {
        case 1:
            text = "To do";
            className = "success";
            break;

        case 2:
            text = "In Development";
            className = "primary";
            break;
        case 3:
            text = "In Test";
            className = "warning";
            break;
        case 4:
            text = "Complete";
            className = "danger";
            break;
    }
    return `<span class='badge badge-${className}'>${text}</span>`;
}

let tl = new TaskLoader(function (items) {
    document.querySelector(".stuff").innerHTML = "";
    items.map(generateTaskHtml).forEach(el => {
        
    document.querySelector(".stuff").appendChild(el)
    });

    
})

tl.type = 1;
tl.start();

document.querySelector(".change").addEventListener("change", e => {
    tl.type = e.target.value;
})
