import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head } from '@inertiajs/inertia-react';

export default function Dashboard(props) {

    const toggle = (event) => {
        event.target.parentElement.querySelector(".nested").classList.toggle("active");
        event.target.classList.toggle("caret-down");
    }

    const territories = props.territories;
    const createTree = (source) => {
        return (
            <>
                {Object.keys(source.children).length < 1 && <span>{source.name}</span>}
                {Object.keys(source.children).length > 0 && (
                    <>
                        <span className="caret" onClick={toggle}>{source.name}</span>
                        <ul className="nested">
                            {Object.keys(source.children).map(id => (
                                <li key={id} className="pl-4">{createTree(source.children[id])}</li>
                            ))}
                        </ul>
                    </>
                )}
            </>
        );
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h2>Territories</h2>
                        <p>Here are the list of territories</p>

                        <ul id="myUL">
                            {Object.keys(territories).map(id => <li key={id} className="pl-4">{createTree(territories[id])}</li>)}
                        </ul>
                    </div>
                </div>
            </div>

        </Authenticated>
    );
}
