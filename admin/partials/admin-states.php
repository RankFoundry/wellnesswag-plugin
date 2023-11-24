<?php
$currentPage = 'States';
include WELLNESS_WAG_PLUGIN_DIR . '/admin/partials/admin-header.php';
?>

<div class="wrap mt-0 bg-slate-50 rounded shadow-md">
    <div class="px-4 sm:px-6 lg:px-8 pb-6">
        <div class="sm:flex sm:items-center mb-6">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-slate-900">States Dropdown</h1>
                <p class="mt-2 text-sm leading-6 text-slate-700">Update the location for each state in the dropdown. To use this dropdown in your content, simply add the shortcode: <code>[wellnesswag-state-dropdown]</code>.</p>
            </div>
        </div>
        
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <form method="post" action="options.php">
                <?php settings_fields($this->plugin_name); ?>

                <dl class="divide-y divide-slate-100">
                    <div class="px-4 py-6">
                        <div class="states-container sm:grid sm:grid-cols-[1fr_2fr] sm:gap-4 sm:items-center sm:px-6 max-w-2xl">
                            <!-- State entries here -->
                        </div>
                        <div class="mt-4 px-4 py-6">
                            <button type="submit" class="h-10 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-slate-600 hover:bg-slate-700 focus:outline-none focus:border-slate-700 focus:ring focus:ring-slate-200 active:bg-slate-800">Save Changes</button>
                        </div>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-900">
                            Reset Defaults
                            <p class="mt-2 text-sm leading-6 text-slate-400">Reset all urls to default</p>
                        </dt>
                        <dd class="mt-1 text-sm leading-6 text-slate-700 sm:col-span-2 sm:mt-0">
                            <button type="button" id="reset" class="mt-2 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-slate-600 hover:bg-slate-700 focus:outline-none focus:border-slate-700 focus:ring focus:ring-slate-200 active:bg-slate-800">Reset</button>
                        </dd>
                    </div>
                </dl>
            </form>
        </div>
    </div>
</div>


<script>
    document.getElementById('reset').addEventListener('click', function() {
        if (confirm("Are you sure you want to reset all values?")) {
            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=reset_states',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    fetchUpdatedStates();
                } else {
                    alert('Reset failed!');
                }
            });
        }
    });

    function fetchUpdatedStates() {
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=fetch_states',
        })
        .then(response => response.json())
        .then(statesData => {
            updateStatesOnPage(statesData);
        });
    }

    function updateStatesOnPage(statesData) {
        // Clear current state entries
        const statesContainer = document.querySelector('.states-container'); // Make sure to add this class to your div containing the states
        statesContainer.innerHTML = '';

        // Add updated state entries
        statesData.forEach(state => {
            const stateEntry = `
                <dt class="text-sm font-medium text-slate-900">${state.name}</dt>
                <dd class="text-sm leading-6 text-slate-700">
                    <input type="text" name="wellnesswag_states[${state.name}]" value="${state.url}" id="state_url" class="h-10 p-2 border rounded w-full">
                </dd>
            `;
            statesContainer.innerHTML += stateEntry;
        });
    }

    // Call fetchUpdatedStates when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        fetchUpdatedStates();
    });
</script>

