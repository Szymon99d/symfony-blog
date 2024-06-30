import axios from 'axios'

export class MassDelete
{
    protected massDeleteUrl: string = "/api/admin/massDelete/";
    protected processingRequest: boolean = false;

    public constructor()
    {
        if(this.getMassDeleteInputs().length > 0 && this.getMassDeleteButton()){
            this.getMassDeleteInputs().forEach((recordCheckInput) => {
                recordCheckInput.addEventListener('click', this.calculateSelectedRecords.bind(this));
            });
            this.getMassDeleteButton().addEventListener('click', this.deleteSelectedRecords.bind(this));
            this.calculateSelectedRecords();
        }
    }

    public checkAllRecords(): void
    {
        this.getMassDeleteInputs().forEach((recordCheckInput) => {
            recordCheckInput.checked = this.getParentCheckInputValue();
        })
        this.calculateSelectedRecords();
    }

    public getMassDeleteInputs(): Array<HTMLInputElement>
    {
        return Array.from(document.querySelectorAll(".check-mass-delete")) as Array<HTMLInputElement>;
    }

    public getMassDeleteButton(): HTMLElement
    {
        return document.querySelector('#massDeleteButton') as HTMLElement;
    }

    public getMassDeleteEntity(): string
    {
        return (document.querySelector('#massDeleteButton') as HTMLElement).dataset.entity;
    }

    public getParentCheckInputValue(): boolean
    {
        return (document.querySelector('#checkAll') as HTMLInputElement).checked;
    }

    protected calculateSelectedRecords(): void
    {
        this.getMassDeleteButton().style.display = this.getMassDeleteInputs().some( (recordCheckInput) => recordCheckInput.checked === true ) ? 'inline-block' : 'none';
    }

    protected deleteSelectedRecords(): void
    {
        if(confirm("Are you sure you want to delete all selected records?") && !this.processingRequest)
        {
            this.processingRequest = true;
            let selectedRecords = [] as Array<string>;
            this.getMassDeleteInputs().forEach( (recordCheckInput) => {
                if(recordCheckInput.checked === true){
                    selectedRecords.push(recordCheckInput.id)
                }
            })
            axios.delete(this.massDeleteUrl + this.getMassDeleteEntity().toLowerCase(), {
                data:{
                    entity: this.getMassDeleteEntity(),
                    selectedRecords: selectedRecords
                }
            }).then(function(){
                location.reload();
            }).catch(function(error){
                console.error(error);
                this.processingRequest = false;
            }).finally(function(){
                this.processingRequest = false;
            })
        }
    }
}
