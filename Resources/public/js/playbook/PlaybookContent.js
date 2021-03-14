$(document).on('click', '.add-taskgroup[data-target]', function(event) {
    var collectionHolder = $($(this).attr('data-target'));

    if (!collectionHolder.attr('data-counter')) {
        collectionHolder.attr('data-counter', 0);
    }

    collectionHolder.attr('data-counter', Number(collectionHolder.attr('data-counter')) + 1);

    var prototype = collectionHolder.attr('data-prototype');
    var form = prototype.replace(/__phase__/g, collectionHolder.attr('data-counter'));

    newWidget = $(collectionHolder.attr('data-widget-tasks')).html(form);
    newWidget.append(collectionHolder.attr('data-task-list'));

    collectionHolder.append(newWidget);

    newWidget.attr('data-counter', collectionHolder.attr('data-counter'));

    addTagFormDeleteLink(newWidget);
    $('.option-min, .option-max').parent().hide();
    event && event.preventDefault();
});

function addTagFormDeleteLink(newWidget) {
    $addQuestionButton = $('<div class="text-center px-4"><button type="button" class="btn btn-info btn-block font-weight-bold"><i class="fas fa-plus mr-2"></i>New Task</button></div>');
    newWidget.append($addQuestionButton);

    newWidget.on('click', '.js-remove-phase' ,function(e) {
        newWidget.remove();
    });

    $addQuestionButton.on('click', function(e){

        if (!newWidget.attr('task-counter')) {
            newWidget.attr('task-counter', 0);
        }

        newWidget.attr('task-counter', Number(newWidget.attr('task-counter'))+ 1);
    
        $holder = $('#taskgroups-field-list');
        $task = $holder.attr('data-prototype-task');
        $taskHolder = newWidget.find('ul');
      
        var task_counter =  newWidget.attr('task-counter');
       
        var form = $task.replace(/__phase__/g, newWidget.attr('data-counter')).replace(/__task__/g, task_counter);

        var newQuestion = $($holder.attr('data-widget-tasks')).html(form);
   
        newQuestion.on('click','.js-remove-task', function(e){
            e.preventDefault();
            $(this).closest('.list-element')
                .fadeOut()
                .remove();
        })
        $taskHolder.append(newQuestion);
    });
}