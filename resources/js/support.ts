 export class DateFormat extends Date
 {
     /**
      * Adiciona um zero à esquerda nos campos com valores menores que 9
      */
     private fillZero(number: number): string
     {
         return number > 9 ? number.toString() : '0' + number.toString();
     }
 
     /**
      * Retorna o valor do campo solicitado (dia, mês, ano, ...)
      */
     private getValue(method: string, utc: boolean): string
     {
         let value = this[
             utc ? method.replace(/get/, 'getUTC') : method
         ]();
         if (/Month/.test(method)) value++;
         
         return this.fillZero(value);
     }
 
     /**
      * Retorna uma string no formato informado
      */
     public format(format: string, utc = false): string
     {
         if (!format) return this.toString();

         return format
             .replace(/Y/g, this.getValue('getFullYear', utc))
             .replace(/m/g, this.getValue('getMonth', utc))
             .replace(/d/g, this.getValue('getDate', utc))
             .replace(/H/g, this.getValue('getHours', utc))
             .replace(/i/g, this.getValue('getMinutes', utc))
             .replace(/s/g, this.getValue('getSeconds', utc));
     }
 
     /**
      * Converte a data informada no formato ISO
      */
     public static iso(date: string): string
     {
         return (new DateFormat(date)).toISOString();
     }
 }
 
 /**
  * Retorna uma nova instância da classe DateFormat
  */
 export function makeDate(date: string): DateFormat
 {
     return date ?
         new DateFormat(date) :
         new DateFormat;
 }