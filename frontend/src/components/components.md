# Wie und wann Komponenten erstellt werden

## Wie
Eine Komponente wird im Ordner "components" erstellt. Jeder Name der Komponente wird in PascalCase geschrieben und dessen Name wird auch im Funktionsnamen fortgeführt.

Komponenten, die von Shadcn/ui kommen haben immer ein "Our" davor, um Namenskonflikte zu vermeiden.

### Beispiel:

**Komponentenname:** ``` LayoutConnector.tsx (kommt nicht von Shadcn)```

**Funktionsdeklaration:**

```javascript
export default function LayoutConnector(props) {
    return (
        <>some JSX</>
    );
}
```

**Komponentenname:** ``` OurDialog.tsx (kommt von Shadcn dialog.tsx)```

**Funktionsdeklaration:**

```javascript
export default function OurDialog(props) {
    return (
        <>some JSX</>
    );
}
```

## Wann

Komponenten erstellen wir immer dann, wenn es dazu kommt, dass wir uns im Code wiederholen müssten.

Wir zerlegen die bereits gestaltete Nutzeroberfläche in Kästen und schauen, wo sich welche Aspekte wiederholen. Wenn da etwas vorliegt, kann dafür eine Komponente gebaut werden.

### Beispiel:

Cards, Layouts, Grid-System, Formulare, Buttons

Man kann also sagen, dass wir für jedes wiederverwendbare UI-Element eine Komponente erstellen. Die Beispiele oben ist das atomarste Element. Das bedeutet, dass diese Komponenten nicht aus anderen Komponenten bestehen dürfen.

## Styling

Gestyled werden die Komponenten über Klassennamen mithilfe von Tailwind. Sollte es aber dazu kommen, dass extra CSS geschrieben werden muss, muss für die Komponente ein Extra-Ordner erstellt werden. Der Name des Stylesheets ist dann in camelCase geschrieben.

### Beispiel für den Speicherort der Komponente "LayoutConnector"

```components/LayoutConnector/LayoutConnector.jsx```

und

```components/LayoutConnector/layoutConnector.css```

Natürlich darf dann nicht vergessen werden, dass das Stylesheet in der Hauptkomponente importiert werden muss.