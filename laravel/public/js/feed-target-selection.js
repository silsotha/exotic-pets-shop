document.addEventListener('DOMContentLoaded', () => {
    const masterCheckboxes =
        document.querySelectorAll('.js-select-all[data-select-all]');

    const getChildren = key =>
        Array.from(
            document.querySelectorAll(
                `.js-select-child[data-select-child="${CSS.escape(key)}"]`
            )
        );

    const syncMasterFromChildren = master => {
        const key = master.dataset.selectAll;
        const children = getChildren(key);

        if (children.length === 0) {
            master.indeterminate = false;
            return;
        }

        const checkedCount = children.filter(
            checkbox => checkbox.checked
        ).length;

        master.checked = checkedCount === children.length;
        master.indeterminate =
            checkedCount > 0 && checkedCount < children.length;
    };

    const syncChildrenFromMaster = master => {
        const key = master.dataset.selectAll;
        const children = getChildren(key);

        children.forEach(checkbox => {
            checkbox.checked = master.checked;
        });

        master.indeterminate = false;
    };

    masterCheckboxes.forEach(master => {
        master.addEventListener('change', () => {
            syncChildrenFromMaster(master);
        });

        syncMasterFromChildren(master);
    });

    document
        .querySelectorAll('.js-select-child[data-select-child]')
        .forEach(child => {
            child.addEventListener('change', () => {
                const key = child.dataset.selectChild;

                const master = document.querySelector(
                    `.js-select-all[data-select-all="${CSS.escape(key)}"]`
                );

                if (master) {
                    syncMasterFromChildren(master);
                }
            });
        });
});
