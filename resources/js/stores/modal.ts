import { SvelteComponent } from "svelte";
import { writable } from "svelte/store";

interface ModalProps {
    [key: string]: string;
}

interface ModalStore {
    component: any;
    props: ModalProps | null;
    closeButton: boolean;
}

const store = writable<ModalStore>({
    component: null,
    props: null,
    closeButton: false,
});

export {
    store as modalContent,
    ModalProps,
    SvelteComponent,
};